const eventHistoryRepository = require('../repository/event_his');
const commonRepository = require('../repository/common');
const runSubjectStateProcessorEvent = require('../../modules/subject_state');
/**
 *
 * @param event
 * @param institution
 * @returns {Promise<void>}
 */
const run_execute_events = async (event, institution) => {
    await runSubjectStateProcessorEvent(institution, event);
}

/**
 *
 * @param message
 * @return {boolean}
 */
const existsRequiredFieldsEvent = (message)=>{
    // console.log('\n\n\n', ' ====== \n',{message}, ' ====== \n','\n\n\n');
    return message.hasOwnProperty('uuid') &&
           message.uuid.length > 0 &&
           message.hasOwnProperty('fired_at') &&
           message.fired_at.length > 0
}

/**
 * get uuid of institution by notatki campus reference
 * @param payload
 * @return {*}
 */
const get_uuid_institution = (payload) => payload?.grade?.grades[0]?.grades[0]?.grades[0]?.notatki?.campus_reference
/**
 *
 * @param messageEvent
 * @returns {Promise<void>}
 */
module.exports = async (messageEvent) => {
    try {
        let institutionUuid = get_uuid_institution(messageEvent);

        if (!institutionUuid) throw new Error("notatki_campus_reference is required")

        if (!existsRequiredFieldsEvent(messageEvent))  throw new Error("uuid and fired_at in event is required")

        let institution = await commonRepository.get_institution_by_campus_uuid(institutionUuid);
        // console.log('\n\n\n', ' ====== \n',{institution}, ' ====== \n','\n\n\n');

        let event = await eventHistoryRepository.create_event_his(messageEvent,institution);

        await run_execute_events(event, institution)
    } catch (error) {
        console.error(`error processing event ${messageEvent.uuid}`, error.message)
    }
}