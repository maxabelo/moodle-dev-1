/**
 * load environment variables
 */
require('dotenv').config();


const {makeIdNumberCourse} = require("../utils/global");
const {
    getSubjectByExternalIdAndInstitutionId,
    createSubjectState,
    updateSubjectState
} = require("../utils/repository/subject_state_sending");

const {finalized_course} = require("../utils/moodle");
const rulesValidator = require('./rules')
const STATE_APPROVED = process.env.STATE_APPROVED_SG;
const STATE_APPROVED_CAMPUS = '_APPROVED';
const STATE_CHANGE_TO_REPROBATE = '_CHANGE_TO_REPROBATE';
let Validator = require('validatorjs');

/**
 *
 * @param institution
 * @param event
 * @returns {Promise<void>}
 */
const approved_course_campus = async (institution, event) => {
    
    let {passes, errors} = validateRequiredFields(event.payload);
    
    if (!passes) throw Error("Validation required fields " + JSON.stringify(errors))
    // console.log('\n\n\n', ' ====== \n',{event, institution}, ' ====== \n','\n\n\n');

    let gradeSubject = mapPayloadEvent(institution, event);
    let gradeSubjectStored = await getSubjectByExternalIdAndInstitutionId(gradeSubject.subject_external_id, institution.id);
    let isApprovedSending = gradeSubject.grade_state === STATE_APPROVED;
    let wasApproved = isStoredAndApproved(gradeSubjectStored);

    isUpdate(gradeSubjectStored) ? gradeSubject.id = gradeSubjectStored.id : gradeSubject = await createSubjectState(gradeSubject)

    try {
        if (isApprovedSending) {
            console.log(`${event.uuid} sending status indicating that it is approved in the SG`)
            //sending status indicating that it is approved in the SG
            let response = await finalized_course(institution, gradeSubject.user_external_id, gradeSubject.course_external_id, STATE_APPROVED_CAMPUS)
            console.log(`${event.uuid} ${STATE_APPROVED_CAMPUS} status from SG sent on campus`, response)
            //update subject state sending
            await updateSubjectState(gradeSubject);
            return;
        }

        if (!wasApproved) {
            console.log(`${event.uuid} state no changed`)
            return;
        }

        console.log(`${event.uuid} submitting status indicating that it was previously approved in the SG`)
        // submitting status indicating that it was previously approved
        let response = await finalized_course(institution, gradeSubject.user_external_id, gradeSubject.course_external_id, STATE_CHANGE_TO_REPROBATE)

        console.log(`${event.uuid} ${STATE_CHANGE_TO_REPROBATE} status from SG sent on campus`, response)
        // update subject state sending
        await updateSubjectState(gradeSubject);
    } catch (error) {
        // actualizar el is error con el mensaje y el detalle del error
        console.error(`Error sending state moodle ${event.uuid}`, error.message)
        await updateSubjectState(gradeSubjectStored, true, error.message);
    }

}
/**
 *
 * @param gradeSubjectStored
 * @returns {boolean}
 */
const isUpdate = (gradeSubjectStored) => {
    return gradeSubjectStored || false;
}

/**
 *
 * @param gradeSubjectStored
 * @returns {boolean}
 */
const isStoredAndApproved = (gradeSubjectStored) => {
    return gradeSubjectStored && gradeSubjectStored.grade_state === STATE_APPROVED
}

/**
 *
 * @param institution
 * @param event
 * @return {{grade_state: *, grade_change_at: *, subject_external_id: any, grade, grade_created_at: *, user_external_id: any, course_external_id: string, event_history_id, institution_id}}
 */
const mapPayloadEvent = (institution, event) => {
    // console.log('\n\n\n', '=======', {payload: event.payload}, '=======', '\n\n\n');
    const payload = event.payload;
    let gradeSubject = payload.grade;
    return {
        subject_external_id: gradeSubject.uuid,
        user_external_id: payload.student.uuid,
        course_external_id: makeIdNumberCourse(payload.subject.uuid, payload.subject.version),
        grade: gradeSubject.value,
        grade_state: gradeSubject.status,
        grade_created_at: gradeSubject.creation_date,
        grade_change_at: gradeSubject.change_date,
        event_history_id: event.id,
        institution_id: institution.id,
    };
}

/**
 *
 * @param {Object} data
 * @return {{passes: boolean, errors: Errors}}
 */
const validateRequiredFields = (data) => {
    let validation = new Validator(data, rulesValidator);
    
    let passes = validation.passes();
    
    let errors = validation.errors;

    // console.log('\n\n\n', ' ====== \n',{passes, errors}, ' ====== \n','\n\n\n'); // da error
    return {passes, errors};
}

module.exports = approved_course_campus

