var config_file = require('./config.json')
var axios = require('axios')
var db = require('../../models')
var global = require('../global')
var autoscore = require('../autoscore')
var socket = require('../socket')

var config = {
    token : config_file.token,
    moodlewsrestformat: config_file.moodlewsrestformat,
    url:config_file.url_path
}

/**
 * 
 * @param {Object} element 
 * @param {Object} campus 
 * @returns boolean
 * Chequea que exista el usuario en moodle
 */

const exist_user_course = async(element,campus) => {
    var token = campus.token || config.token
    
    var url_api = `${campus.website}${config.url}`

    var body = new URLSearchParams()
    body.append('wstoken',token)
    body.append('wsfunction','core_enrol_get_users_courses')
    body.append('moodlewsrestformat',config.moodlewsrestformat)
    body.append('userid',element.user_id)
    body.append('returnusercount',0)
    var response_moodle = await axios.post(url_api,body)

    var exist_in_course = response_moodle.data.some((e) => e.id == element.course_id )

    if (!exist_in_course) {
        var process_status = await global.get_process_status('USER_NOT_FOUND')
        await autoscore.grade_sending_updated_process_status(element.id,process_status)
    }

    return exist_in_course
}

/**
 * 
 * @param {Object} element 
 * @param {Object} campus 
 * @returns Object|null
 * Revisa si ya posee una calificacion en moodle 
 */

const exist_score = async(element,campus) => {
    
    var token = campus.token || config.token
    
    var url_api = `${campus.website}${config.url}`

    var body = new URLSearchParams()
    body.append('wstoken',token)
    body.append('wsfunction','gradereport_user_get_grade_items')
    body.append('moodlewsrestformat',config.moodlewsrestformat)
    body.append('courseid',element.course_id)
    body.append('userid',element.user_id)

    var response_moodle = await axios.post(url_api,body)

    if('usergrades' in response_moodle.data){
        var grades = response_moodle.data.usergrades[0].gradeitems;

        var exist_score = grades.filter((el)=>{
            return el.cmid === element.activity_id && el.itemname != null
        })

        if(exist_score.length == 0){
            return null
        }else{
            return exist_score[0]
        }

    }else{
        if(response_moodle.data.errorcode == 'invaliduser'){
            var process_status = await global.get_process_status('USER_NOT_FOUND')
            await autoscore.grade_sending_updated_process_status(element.id,process_status)
        }else{
            var process_status = await global.get_process_status('MOODLE_ERROR')
            await autoscore.grade_sending_updated_process_status(element.id,process_status)
            console.error(`EXIST score ${JSON.stringify(response_moodle.data)} in ${element.grade_receiver_id}`);
        }
        return null
    }
}

/**
 * 
 * @param {Object} element 
 * @param {Object} campus 
 * Envia la calificacion a una tarea
 */

const send_grade_assign = async (element,campus) => {

    var token = campus.token || config.token

    var url_api = `${campus.website}${config.url}`

    var body = new URLSearchParams()
    body.append('wstoken',token)
    body.append('wsfunction','mod_assign_save_grade')
    body.append('moodlewsrestformat',config.moodlewsrestformat)
    body.append('assignmentid',element.instance_id)
    body.append('userid',element.user_id)
    body.append('grade',element.score_to_assign)
    body.append('attemptnumber','-1')
    body.append('addattempt',0)
    body.append('workflowstate','graded')
    body.append('applytoall','0')    

    console.log('sending grade for assign: ',body);
    var response_moodle = await axios.post(url_api, body);
    console.log('response: ', response_moodle);
    if (response_moodle.data == null) {
        var process_status = await global.get_process_status('SUCCESSFUL_MOODLE')
        await autoscore.grade_sending_updated_process_status(element.id,process_status)
    }else{
        var process_status = await global.get_process_status('MOODLE_ERROR')
        await autoscore.grade_sending_updated_process_status(element.id,process_status)
        console.error(`exist SCORE ${response_moodle.data} in ${element.grade_receiver_id}`);
    }
}

/**
 * 
 * @param {Object} element 
 * @param {Object} campus 
 * Envia la calificacion de un foro
 */
const send_grade_forum = async (element,campus) => {
 
    var token = campus.token || config.token

    var url_api = `${campus.website}${config.url}`

    var body = new URLSearchParams()
    body.append('wstoken',token)
    body.append('wsfunction','core_grades_grader_gradingpanel_point_store')
    body.append('moodlewsrestformat',config.moodlewsrestformat)
    body.append('component','mod_forum')
    body.append('contextid',element.context_id)
    body.append('itemname','forum')
    body.append('notifyuser',1)
    body.append('gradeduserid',element.user_id)
    body.append('formdata',`grade=${element.score_to_assign}`)

    console.log('sending grade forum ',body);
    var response_moodle = await axios.post(url_api,body)    
    console.log('response: ', response_moodle);

    if ('grade' in response_moodle.data) {
        var process_status = await global.get_process_status('SUCCESSFUL_MOODLE')
        await autoscore.grade_sending_updated_process_status(element.id,process_status)
    }else{
        var process_status = await global.get_process_status('MOODLE_ERROR')
        await autoscore.grade_sending_updated_process_status(element.id,process_status)
        console.error(`EXIST SCORE ${response_moodle.data} in ${element.grade_receiver_id}`);
    }
}

module.exports = {

    set_configs: (token, moodlewsrestformat) => {
        config.token = token
        config.moodlewsrestformat = moodlewsrestformat
    },
    check_config: () => {
        if(config){
            return config
        }else{
            throw new Error("not configuration set, use set_configs first")
        }
    },
    /**
     * 
     * @param {Object} element 
     * @returns Array
     * Recive todas la calificaciones y las envia a guardar a moodle
     */
    async send_grade(element){        

        var in_process_grade_sending = element.in_process_grade_sending;
        var institutions = element.institutions;

        var array_petitions = []
        
        for (let index = 0; index < in_process_grade_sending.length; index++) {
            
            const element = in_process_grade_sending[index];

            console.log(`Procesando grade sending con uuid: ${element.uuid}`);
            
            var process_status = await global.get_process_status('PROCESSING')
            
            await autoscore.grade_sending_updated_process_status(element.id,process_status)

            var campus = institutions.find((item)=>{
                return item.id == element.institution_id
            })

            if(campus != undefined){
                var score = await exist_score(element,campus)
                var user_course = await exist_user_course(element,campus)         

                if(score && user_course){
                    if (!score.graderaw) {
                        if (element.source == 'assign') {
                            await send_grade_assign(element,campus)
                        }else{
                            await send_grade_forum(element,campus)
                        }
                    }else{
                        process_status = await global.get_process_status('EXISTING_GRADE')
                        await autoscore.grade_sending_updated_process_status(element.id,process_status)
                    }
                }else if(!score && user_course){
                    if (element.source == 'assign') {
                        await send_grade_assign(element,campus)
                    }else{
                        await send_grade_forum(element,campus)
                    }
                }
                socket.emit.push_updated_grade_sending(element)
            }else{
                console.error(`Campus ${element.institution_id} does not exist`);
            }
        }
        
        return array_petitions;
    }
}
