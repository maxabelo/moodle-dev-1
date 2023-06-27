import { Sequelize } from 'sequelize';

import User from './models/user.js';

// // NOOO tener 2 connections a db
// import knex from 'knex';
// knex({
//   client: 'mysql2',
//   connection: {
//     host: '127.0.0.1',
//     port: 3306,
//     user: 'root',
//     password: 'root',
//     database: 'todos_sequelize',
//   },
// });

const sequelize = new Sequelize('todos_sequelize', 'root', 'root', {
  host: 'localhost',
  dialect: 'mysql',
});

const connectToDB = async () => {
  try {
    await sequelize.authenticate();
    console.log('Connection has been established successfully.');

    // // // Inserts
    // // Raw Query - MySQL: Escribir la Query de SQL a pelo, pero NO Sanitiza ni nada de lo q hace Sequelize al usar sus methods (seguros) - raw no previene inyecciones sql
    /*     await sequelize.query(`
			INSERT INTO users (name, email, password, createdAt, updatedAt)
			VALUES ('Alex', 'alex@axes.com', '123', NOW(), NOW());
		`); */

    // // Query Bulder - knex:
    /* await knex('users').insert({
      name: 'Manolo',
      email: 'manolo@ma.com',
      password: '1234',
      createdAt: new Date(), // hace el caste a date sql
      updatedAt: new Date(), // hace el caste a date sql
    }); */

    // // ORM
    /*     await User.create({
      name: 'Manolo',
      email: 'manolo@ma.com',
      password: '1234',
    }); */

    // // // Query
    // // Raw Query
    // const [results] = await sequelize.query('SELECT * FROM users;');
    // console.log(results[0].name);

		// // Query Builder
		// const results = await knex('users').where('name', 'manolo').select()

		// // ORM
		
  } catch (error) {
    console.error('Unable to connect to the database:', error);
  }
};
connectToDB();
