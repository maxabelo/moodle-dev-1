module.exports = (db,DataTypes) => {
    const grade_sending = db.define('grade_sending',{
        id:{type: DataTypes.INTEGER, primaryKey: true, allowNull: false, autoIncrement: true},

        uuid:{type: DataTypes.TEXT, allowNull:false},
        user_id:{type: DataTypes.INTEGER, allowNull: false},
        course_id:{type: DataTypes.INTEGER, allowNull: false},
        context_id:{type: DataTypes.TEXT, allowNul: false},
        source:{type: DataTypes.TEXT, allowNull: false},
        component:{type: DataTypes.TEXT, allowNull: false},
        activity_id:{type: DataTypes.INTEGER, allowNull: false},
        instance_id:{type: DataTypes.INTEGER, allowNull: false},
        score_to_assign:{type: DataTypes.FLOAT, allowNull: false},
        date_to_grade:{type: DataTypes.TEXT, allowNul:false},
        item_number:{type: DataTypes.INTEGER,allowNul:false}
    },
    {
        underscored: true,
        freezeTableName: true
    });
    return grade_sending;
}