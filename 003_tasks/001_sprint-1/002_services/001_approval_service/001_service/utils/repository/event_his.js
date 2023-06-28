var db = require('../../models')



/**
 * create record in event history
 * @param {Object} body
 * @param {Object} institution
 * @returns {Promise<*>}
 */
const create_event_his = async (body,institution) => {
    return await db.event_history.create({
        uuid: body.uuid,
        fired_at: body.fired_at,
        payload: body,
        institution_abbreviation: institution?.abbreviation.toUpperCase().trim()
    });
}

module.exports = {
    create_event_his
}
