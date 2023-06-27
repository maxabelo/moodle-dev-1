import { DataTypes } from 'sequelize';
import bcryptjs from 'bcryptjs';

import db from '../db/db.js';

const User = db.define(
  'users',
  {
    name: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    email: {
      type: DataTypes.STRING,
      allowNull: false,
      unique: true,
    },
    password: {
      type: DataTypes.STRING,
      allowNull: false,
    },
  },
  {
    hooks: {
      beforeCreate: async function (user) {
        user.password = await bcryptjs.hash(user.password, 10);
      },
    },
    // suprimir info antes de pasarla
    scopes: {
      removePassword: {
        attributes: {
          exclude: ['password', 'token', 'createdAt', 'updatedAt'],
        },
      },
    },
  }
);

// Custom methods
User.prototype.comparePassword = async function (password) {
  return await bcryptjs.compare(password, this.password);
};

export default User;
