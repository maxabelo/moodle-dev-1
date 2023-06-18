const cron = require('node-cron')
const socket = require('../socket')
const db = require('../../models')
const global = require('../global')
const moodle = require('../moodle')
const env = process.env;
/** 
# ┌────────────── second (optional)
# │ ┌──────────── minute
# │ │ ┌────────── hour
# │ │ │ ┌──────── day of month
# │ │ │ │ ┌────── month
# │ │ │ │ │ ┌──── day of week
# │ │ │ │ │ │
# │ │ │ │ │ │
# * * * * * *

*/

const start_job = async () => {

    // normal autoscore cronjob (set califications to students that are in the line waiting)

    cron.schedule(env.CRONJOB_AUTOSCORE, async () => {
        await updated_autoscore_status('AUTOSCORE','init')
        socket.emit.push_cronjob_status()

        var response = await run_autoscore_cronjob()
        console.log(response);
        
        await updated_autoscore_status('AUTOSCORE','end')
        socket.emit.push_cronjob_status()
    })
    
    // clean autscore (remove all the cronjobs that has been created from 3 years ago)

    cron.schedule(env.CRONJOB_CLEANER, async () => {
        await run_autoscore_cleaner()
    })

    // retry all the cronjobs that return with moodle error (user not found)
}

const cronjob_user_not_found = async () => {
    cron.schedule(env.CRONJOB_USER_NOT_FOUND, async () => {
        
        await updated_autoscore_status('USERNOTFOUND','init')
        socket.emit.push_cronjob_status()
        
        await run_autoscore_usernotfound()      

        await updated_autoscore_status('USERNOTFOUND','end')
        socket.emit.push_cronjob_status()
    })
}

const get_crons = async () => {
    return await db.cronjob.findAll()
}

const run_autoscore_cronjob = async () => { 
    var datenow = new Date(Date.now()).toISOString()

    var process_status_in_process = await global.get_process_status('WAITING_TO_SEND');
    //mapa de logica
    var in_process_grade_sending = await db.grade_sending.findAll({
        where: {
            process_status_id: process_status_in_process.id,
            date_to_grade:{
                [db.op.lte]:datenow
            }
        },
        raw:true
    })
    if (in_process_grade_sending.length != 0) {
        
        var institutions = await global.get_institutions()
        if (institutions) {
            var moodle_response = await moodle.send_grade({in_process_grade_sending,institutions})
            return moodle_response
        }else{
            console.error("no existe el campus");
        }
    }else{
        console.error("vacio los grades to send");
    }

}

const run_autoscore_cleaner = async() => {

    /// cualquiera que no este en estado WAITING_TO_SEND sera borrado

    await updated_autoscore_status('CLEANER')
    socket.emit.push_cronjob_status()
    
    var status = await db.process_status.findAll({
        where:{
            process_abbreviation:{
                [db.op.notLike]:'WAITING_TO_SEND'
            }
        }
    })
    
    const arrays_id_status = status.map(object => object.id)

    var grade_sending_to_remove = await db.grade_sending.findAll({
        where:{
            process_status_id:{
                [db.op.in]:arrays_id_status
            }
        }
    });
    
    const arrays_id_grade_sending = grade_sending_to_remove.map(object => object.id)
    const arrays_id_grade_receiver = grade_sending_to_remove.map(object => object.grade_receiver_id)
    
    //todas las removidas que se necesitan

    await db.grade_sending.destroy({
        where:{
            id:{
                [db.op.in]:arrays_id_grade_sending
            }
        }
    })

    await db.grade_receiver.destroy({
        where:{
            id:{
                [db.op.in]:arrays_id_grade_receiver
            }
        }
    })

    await updated_autoscore_status('CLEANER')
    socket.emit.push_cronjob_status()
}

const run_autoscore_usernotfound = async () => {

    await updated_autoscore_status('USERNOTFOUND')
    socket.emit.push_cronjob_status()

    var status = await global.get_process_status('USER_NOT_FOUND');
    var datenow = new Date().toISOString()
    var grade_sending = await db.grade_sending.findAll({
        where: {
            process_status_id:status.id,
            date_to_grade:{
                [db.op.lte]:datenow
            }
        }
    })
    if (grade_sending.length != 0) {
        var institutions = await global.get_institutions()
        if (institutions) {
            var moodle_response = await moodle.send_grade({grade_sending,institutions})
            return moodle_response
        }else{
            console.error("no existe el campus");
        }
    }else{
        console.error("vacio los grades to send user not found");
    }

    await updated_autoscore_status('USERNOTFOUND')
    socket.emit.push_cronjob_status()
}

const updated_autoscore_status = async (abbreviation,state) => {
    const cron = await db.cronjob.findOne({
        where: {
            abbreviation : abbreviation
        }
    })
    await db.cronjob.update({
        running:state == 'init' ? true : false
    },{
        where:{
            abbreviation: cron.abbreviation
        }
    })
}


module.exports = {start_job,get_crons,run_autoscore_cronjob,run_autoscore_cleaner,run_autoscore_usernotfound,cronjob_user_not_found};