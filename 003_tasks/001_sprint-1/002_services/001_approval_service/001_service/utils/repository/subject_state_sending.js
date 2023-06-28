
const db = require("../../models");

/**
 *
 * @param externalId
 * @param institutionId
 * @returns {Promise<Model|null>}
 */
const getSubjectByExternalIdAndInstitutionId = async (externalId,institutionId)=>{
    return await db.subject_state_sending.findOne({
        where: {
            subject_external_id: externalId,
            institution_id: institutionId
        }
    })
}

/**
 *
 * @param subjectStateSending
 * @returns {Promise<Object>}
 */
const createSubjectState = async (subjectStateSending)=>{
   return await db.subject_state_sending.create(subjectStateSending);
}

/**
 *
 * @param subjectStateSending
 * @param isError
 * @param detailError
 * @returns {Promise<Object>}
 */
const updateSubjectState = async (subjectStateSending,isError = false, detailError= null)=>{
    return await db.subject_state_sending.update({
        grade : subjectStateSending.grade,
        grade_state : subjectStateSending.grade_state,
        grade_change_at: subjectStateSending.grade_change_at,
        is_error : isError,
        detail_error: detailError,
        event_history_id: subjectStateSending.event_history_id
    },{
        where: {
            id: subjectStateSending.id
        }
    });
}

module.exports = {
    getSubjectByExternalIdAndInstitutionId,
    createSubjectState,
    updateSubjectState
}