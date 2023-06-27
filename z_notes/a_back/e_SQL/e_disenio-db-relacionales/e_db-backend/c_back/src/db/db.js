import { Sequelize } from 'sequelize';

import {
  DB_DIALECT,
  DB_HOST,
  DB_NAME,
  DB_PASSWORD,
  DB_PORT,
  DB_USER,
} from '../config/index.js';

const db = new Sequelize(DB_NAME, DB_USER, DB_PASSWORD, {
  host: DB_HOST,
  dialect: DB_DIALECT,
  port: DB_PORT,
  define: { timestamps: true },

  pool: {
    max: 5,
    min: 0,
    acquire: 30000,
    idle: 10000,
  },
});

(async () => {
  try {
    await db.authenticate();
    await db.sync(); // dev
    console.log('Connection has been established successfully.');

    // // // Queries
    // // Raw Query: Nadie hace queries a pelo, dos da problemas con tablas con el mismo name
    // const [resultsRQ] = await db.query(`SELECT * FROM users JOIN tasks ON tasks.userId = users.id`);
    // console.log(resultsRQ);

    // const [results] = await db.query(`
    //   SELECT * FROM users
    //   JOIN tasks ON tasks.userId = users.id
    //   WHERE tasks.completed = FALSE
    //   AND YEAR(tasks.due_date) = 2022
    //   AND MONTH(tasks.due_date) < 6;
    // `);
    // console.log(results);
  } catch (error) {
    console.log(error);
  }
})();

export default db;
