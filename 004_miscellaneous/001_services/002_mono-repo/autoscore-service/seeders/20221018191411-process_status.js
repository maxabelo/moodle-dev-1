'use strict';

var process_status = require('../config/seeders/process_status')
var db = require('../models')

/** @type {import('sequelize-cli').Migration} */
module.exports = {
  
  async up (db) {

    for (let index = 0; index < process_status.length; index++) {
      const element = process_status[index];
      await db.process_status.findOrCreate({
        where:{
          process_abbreviation:element.process_abbreviation
        },
        defaults:{
          uuid:element.uuid,
          process:element.process,
          process_abbreviation:element.process_abbreviation,
        }
      })
    }
    //return queryInterface.bulkInsert('process_status',process_status)
},

  async down (queryInterface, Sequelize) {
    return queryInterface.bulkDelete('process_status',null,{})
  }
};
