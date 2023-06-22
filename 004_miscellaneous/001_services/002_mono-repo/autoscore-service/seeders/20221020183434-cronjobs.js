'use strict';

var cronjobs = require('../config/seeders/cronjob')

/** @type {import('sequelize-cli').Migration} */
module.exports = {
    async up(db) {
      for (let index = 0; index < cronjobs.length; index++) {
        const element = cronjobs[index];
        var[cronjob,create] = await db.cronjob.findOrCreate({
          where:{
            abbreviation:element.abbreviation
          },
          defaults:{
            title:element.title,
            abbreviation:element.abbreviation,
            running:element.running,
            nextRun:element.next_run,
            icon:element.icon
          }
        })

        if (create) {
          const update = await db.cronjob.update({
            running:false
            },{
                where:{
                    abbreviation: cronjob.abbreviation
                }
            })
        }
      }
    },
  
  
  
    async down(queryInterface, Sequelize) {
      /**
       * Add commands to revert seed here.
       *
       * Example:
       * await queryInterface.bulkDelete('People', null, {});
       */
      await queryInterface.bulkDelete('cronjob', null, {})
    }
  };