'use strict';

/**
 * load environment variables
 */
require('dotenv').config();

const fileSeed = process.env.SEED_INSTITUTION_LOAD_FILE || 'institutions.production';

const institutions = require(`../config/seeders/${fileSeed}.js`)

/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up(db) {
    for (let index = 0; index < institutions.length; index++) {
      const element = institutions[index];
      await db.institution.findOrCreate({
        where:{
          uuid:element.uuid
        },
        defaults:{
          uuid:element.uuid,
          name:element.name,
          fullname:element.fullname,
          abbreviation:element.abbreviation,
          domain:element.domain,
          website:element.website,
          restPath:element.rest_path,
          modality:element.modality.toUpperCase(),
          translations:element.translations,
          token:element.token,
          campus_uuid: element.campus_uuid
        }
      })
    }
  },

  async down(queryInterface, Sequelize) {
    return queryInterface.bulkDelete('institution',null,{})
  }
};
