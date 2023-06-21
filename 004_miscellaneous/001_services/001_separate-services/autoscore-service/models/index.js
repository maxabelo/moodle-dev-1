'use strict';

const fs = require('fs');
const path = require('path');
const Sequelize = require('sequelize');
const {
    DataTypes,
    Op
} = require('sequelize');
const basename = path.basename(__filename);
const db = {};
const env = process.env;

let sequelize = new Sequelize(env.DATABASE_DATABASE, env.DATABASE_USERNAME, env.DATABASE_PASSWORD, {
    host: env.DATABASE_HOST,
    dialect: env.DATABASE_DIALECT,
    port: env.DATABASE_PORT,
    logging: false
});

fs
    .readdirSync(__dirname)
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

db.grade_sending.belongsTo(db.grade_receiver, {
    foreignKey: {
        name:'grade_receiver_id',
        allowNull: false
    }
})
db.grade_sending.belongsTo(db.institution, {
    foreignKey: {
        name: 'institution_id',
        allowNull: false
    }
})
db.grade_sending.belongsTo(db.process_status, {
    foreignKey: {
        name: 'process_status_id',
        allowNull: false,
        onDelete: 'cascade'
    }
})

//


db.sequelize = sequelize;
db.Sequelize = Sequelize;
db.op = Op;

module.exports = db;