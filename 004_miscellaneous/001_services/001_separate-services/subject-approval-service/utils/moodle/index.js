const axios = require('axios');
const functions = require('./functions');
const config = require('./config');


/**
 *
 * @param {Object} institution
 * @param {String} userIdNumber
 * @param {String} courseIdNumber
 * @param {String} state
 * @returns Promise<Object>
 * Chequea que exista el usuario en moodle
 */

const finalized_course = async (institution, userIdNumber, courseIdNumber, state) => {

    const token = institution.token

    const url_api = `${institution.website}${institution.restPath}`

    let body = new URLSearchParams()
    body.append('wstoken', token)
    body.append('wsfunction', functions.finalized_course)
    body.append('moodlewsrestformat', config.moodlewsrestformat)
    body.append('user[idnumber]', userIdNumber)
    body.append('course[idnumber]', courseIdNumber)
    body.append('state', state)

    const response = await axios.post(url_api, body)



    validateSuccessResponseOrFails(body, response);

    return response.data
}

/**
 * @param {Object} request
 * @param {Object} response
 * @return  {Boolean}
 */
const validateSuccessResponseOrFails = (request, response) => {

    let isError = response.status !== 200 ||
        response.data.hasOwnProperty("message") ||
        (response.data.hasOwnProperty("warnings") && response.data.warnings.length > 0)

    if (!isError) return true;

    throw Error("Campus Request failed: \n" +
        "Request:" + JSON.stringify(Object.fromEntries(request)) + "\n" +
    "Response:" + JSON.stringify(response.data) + "\n");

}

module.exports = {
    finalized_course
}
