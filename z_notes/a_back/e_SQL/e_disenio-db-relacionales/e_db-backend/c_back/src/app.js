import express from 'express';
import { Op } from 'sequelize';

import './db/db.js';
import { Task, User } from './models/index.js';
import { SEED_TASKS, SEED_USERS } from './seed/index.js';

const app = express();

// Middlewares
// setupMiddlewares(app);

// Routes
// app.use('/auth', authRoutes);

const seedData = async () => {
  // const users = await User.findOne({ where: { name: 'Alex' } });
  // console.log(users);

  // // inserts
  // await User.bulkCreate(SEED_USERS);
  // await Task.bulkCreate(SEED_TASKS);

  // // // Queries
  // // Raw Query - en donde tenga la conexion a db

  // // ORM
  // const tasks = await Task.findAll({ include: [{ model: User, as: 'user' }] });
  // console.log(JSON.stringify(tasks, null, 4));

  // const users = await User.findAll({ include: Task });
  // console.log(JSON.stringify(users, null, 4));


  
  /* 
  const [results] = await db.query(`
      SELECT * FROM users
      JOIN tasks ON tasks.userId = users.id
      WHERE tasks.completed = FALSE
      AND YEAR(tasks.due_date) = 2022
      AND MONTH(tasks.due_date) < 6;
    `);
   */
  // task tiene condiciones asociadas, asi q las colocamos en el Include
  const users = await User.findAll({
    include: {
      model: Task,
      where: {
        completed: false,
        due_date: { [Op.lt]: new Date('2022-06-01') },

        // [Op.and]: [ // x default es and, asi q lo podemos omiti
        //   { completed: false },
        //   { due_date: { [Op.lt]: new Date('2022-06-01') } },
        // ],
      },
    },
  });

  console.log(JSON.stringify(users, null, 4));
};
seedData();

export default app;
