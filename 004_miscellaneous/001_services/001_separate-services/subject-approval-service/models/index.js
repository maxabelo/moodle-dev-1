'use strict';

const fs = require('fs');
const path = require('path');
const Sequelize = require('sequelize');
const {DataTypes, Op } = require('sequelize');
const basename = path.basename(__filename);
const db = {};
const env = process.env;

let sequelize = new Sequelize(env.DATABASE_DATABASE, env.DATABASE_USERNAME, env.DATABASE_PASSWORD, {
    host: env.DATABASE_HOST,
    dialect: env.DATABASE_DIALECT,
    port: env.DATABASE_PORT,
    logging: false
});

fs.readdirSync(__dirname)
    .filter(file => {
        return (file.indexOf('.') !== 0) && (file !== basename) && (file.slice(-3) === '.js');
    })
    .forEach(file => {
        const model = require(path.join(__dirname, file))(sequelize, Sequelize.DataTypes)
        db[model.name] = model;
    });

Object.keys(db).forEach(modelName => {
    if (db[modelName].associate) {
        db[modelName].associate(db);
    }
});


//ASSOCIATIONS

db.subject_state_sending.belongsTo(db.event_history, {
    foreignKey: {
        name:'event_history_id',
        allowNull: false
    }
})
db.subject_state_sending.belongsTo(db.institution, {
    foreignKey: {
        name: 'institution_id',
        allowNull: false
    }
})



db.sequelize = sequelize;
db.Sequelize = Sequelize;
db.op = Op;

module.exports = db;