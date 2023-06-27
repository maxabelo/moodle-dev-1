module.exports = (db,DataTypes) => {
    return db.define('subject_state_sending',{
        id:{type: DataTypes.INTEGER, primaryKey: true, allowNull: false, autoIncrement: true},
        subject_external_id :{type: DataTypes.TEXT, allowNull:false},
        user_external_id:{type: DataTypes.TEXT, allowNull: false},
        course_external_id:{type: DataTypes.TEXT, allowNull: false},
        grade: {type: DataTypes.FLOAT, allowNul:false},
        grade_state: {type: DataTypes.STRING, allowNul:false},
        grade_created_at : {type: DataTypes.DATE, allowNul:false},
        grade_change_at : {type: DataTypes.DATE, allowNul:false},
        is_error: {type: DataTypes.BOOLEAN, allowNul:true, defaultValue:false},
        detail_error: {type: DataTypes.TEXT, allowNul:true},
    },
    {
        underscored: true,
        freezeTableName: true
    });
}