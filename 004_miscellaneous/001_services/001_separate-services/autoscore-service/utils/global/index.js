const db = require('../../models')

//funciones globales que se usan atravez del servicio

/**
 * 
 * @param {String} abbreviation 
 * @returns Object
 * Retorna el estado existentes en la base de datos
 */
const get_process_status = async (abbreviation) => {
    try {
        var process_status = await db.process_status.findOne({
            where: {
                process_abbreviation: abbreviation
            }
        })
        if (process_status) {
            return process_status
        } else {
            throw new Error('Process status not found')
        }
    } catch (error) {
        console.error(error);
    }
}

/**
 * 
 * @returns Array
 * Obtiene todas las instituciones existentes
 */
const get_institutions = async () => {
    return db.institution.findAll()
}

/**
 * 
 * @returns Array
 * Retorna todos los estados existentes en la base de datos
 */

const get_all_process_status = async () => {
    return db.process_status.findAll()
}

/**
 * 
 * @param {String} abbreviation 
 * @param {String} modality 
 * @returns Object
 * Obtiene la institucion por abreviatura y modalidad
 */
const get_institution_by_abbreviation_modality = async (abbreviation,modality) => {
    return await db.institution.findOne({
        where:{
            abbreviation:abbreviation,
            modality:modality.toUpperCase()
        }
    })
}

/**
 * 
 * @param {String} abbreviation 
 * @returns Object
 * Obtiene la institucion por abreviatura
 */

const get_institution_by_abbreviation = async (abbreviation) => {
    var institution = await db.institution.findOne({
        where: {
            abbreviation: abbreviation
        }
    })
    return institution
}



module.exports = {
    get_process_status,
    get_institutions,
    get_all_process_status,
    get_institution_by_abbreviation,
    get_institution_by_abbreviation_modality
}