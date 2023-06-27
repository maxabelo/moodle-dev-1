import Task from './Tasks.js';
import User from './User.js';

User.hasMany(Task, { onDelete: 'CASCADE', onUpdate: 'CASCADE' });
Task.belongsTo(User, { foreignKey: { name: 'userId' } });

export { User, Task };
