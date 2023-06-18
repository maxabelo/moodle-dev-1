var db = require('../../models')
var global = require('../global')
const socket = require('../socket')

/**
 * 
 * @param {Object} body 
 * @returns Object
 * Guarda el autoscore recivido desde rabbit
 */

const created_autoscore = async (body) => {
    var grade_receiver_row = await create_grade_receiver_row(body)
    if (grade_receiver_row) {
        var process_status_in_process = await global.get_process_status('WAITING_TO_SEND');
        var institution = await global.get_institution_by_abbreviation_modality(grade_receiver_row.institution_abbreviation, grade_receiver_row.modality)
        if (institution) {
            return await findOrCreate_grade_sending(grade_receiver_row, institution, process_status_in_process)
        }
    }
}

/**
 * 
 * @param {Object} grade_receiver_row 
 * @param {Object} institution 
 * @param {Object} process_status 
 * @returns Object
 * 
 * Busca o crea si no existe el registro del autoscore
 */

const findOrCreate_grade_sending = async (grade_receiver_row, institution, process_status) => {
    
    var response = new Object()

    const [grade_sending_row, created] = await db.grade_sending.findOrCreate({
        where: {
            uuid: grade_receiver_row.uuid
        },
        defaults: {
            uuid: grade_receiver_row.uuid,
            user_id: grade_receiver_row.assignment.user_id,
            course_id: grade_receiver_row.assignment.course_id,
            source: grade_receiver_row.assignment.source,
            component: grade_receiver_row.assignment.component,
            instance_id:grade_receiver_row.assignment.instance_id,
            context_id: grade_receiver_row.assignment.contextid,
            activity_id: grade_receiver_row.assignment.activity_id,
            score_to_assign: grade_receiver_row.assignment.score_to_assign,
            date_to_grade: grade_receiver_row.assignment.date_to_grade,
            item_number: grade_receiver_row.assignment.item_number,
            process_status_id: process_status.id,
            grade_receiver_id: grade_receiver_row.id,
            institution_id: institution.id
        }
    })
    if (created) {
        response.exist = false
        response.create_grade_sending = await get_grade_sending_by_pk(grade_sending_row.id)
        socket.emit.push_new_grade_sending(response.create_grade_sending)
    } else {
        response.exist = true
        response.create_grade_sending = await get_grade_sending_by_pk(grade_sending_row.id)
    }

    return response

}

const create_grade_receiver_row = async (body) => {
    const [grade_receiver_row, created] = await db.grade_receiver.findOrCreate({
        where:{
            uuid: body.uuid
        },
        defaults: {
            uuid: body.uuid,
            fired_at: body.fired_at,
            assignment: body.assignment,
            institution_abbreviation: body.institution_abbreviation,
            modality: body.modality
        }
    })
    return grade_receiver_row
}

/**
 * 
 * @param {Number} page 
 * @param {Number} size 
 * @returns Object
 * 
 * Obtiene la paginacion para la tabla (api rest)
 */
const getPagination = (page, size) => {

    const limit = size ? +size : 3;
    const offset = page ? page * limit : 0;

    return {
        limit,
        offset
    }
}

/**
 * 
 * @param {String} autoscore_uuid 
 * @returns Object
 * Retorna el autoscore por uuid
 */
const get_autoscore_by_uuid = async (autoscore_uuid) => {
    var autoscore = await db.grade_sending.findOne({
        where: {
            uuid: autoscore_uuid
        },
        include: [db.process_status, db.grade_receiver, db.institution]
    })
    return autoscore
}
/**
 * 
 * @param {Object} body 
 * @returns Array
 * Retorna el arreglo del autoscore tomando en cuenta la paginacion
 */
const get_autoscore = async (body) => {
    
    const {
        limit,
        offset
    } = getPagination(body.options.page, body.options.itemsPerPage)

    const whereStatement = new Object();
    if(body.filter != undefined){
        if(body.filter.institution) whereStatement.institution_id = body.filter.institution
        if(body.filter.status) whereStatement.process_status_id = body.filter.status
        if(body.filter.date) whereStatement.created_at = {[db.op.lte] : `${body.filter.date} 23:59:59`}
    }

    var autoscore = await db.grade_sending.findAndCountAll({
        include: [db.process_status, db.grade_receiver, db.institution],
        where:whereStatement,
        limit,
        offset,
        order: [
            [
                body.options.sortBy == undefined ? 'id' : body.options.sortBy[0],
                body.options.sortBy == undefined ? 'DESC' : body.options.sortDesc[0] === 'true' ? 'DESC' : 'ASC'
            ]
        ]
    });
    return autoscore;
}

/**
 * 
 * @param {Number} grade_sending_pk 
 * @returns Object
 * Retorna el registro del grado por enviar a moodle
 */
const get_grade_sending_by_pk = async (grade_sending_pk) => {
    return await db.grade_sending.findByPk(grade_sending_pk, {
        include: [db.process_status, db.grade_receiver, db.institution]
    })
}

/**
 * 
 * @param {Number} id 
 * @param {Object} process_status 
 * @returns Boolean
 * Actualiza el registro del grado
 */
const grade_sending_updated_process_status = async (id, process_status) => {
    return await db.grade_sending.update({
        process_status_id: process_status.id
    }, {
        where: {
            id: id
        }
    })
}



module.exports = {
    created_autoscore,
    get_autoscore,
    get_autoscore_by_uuid,
    grade_sending_updated_process_status,
    get_grade_sending_by_pk
}