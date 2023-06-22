'use strict';

const institutions = require('../config/seeders/institutions')

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
          token:element.token
        }
      })
    }
  },

  async down(queryInterface, Sequelize) {
    return queryInterface.bulkDelete('institution',null,{})
  }
};
