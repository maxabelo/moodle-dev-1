module.exports = (db,DataTypes) => {
    const grade_receiver = db.define('grade_receiver',{
        id:{type: DataTypes.INTEGER, primaryKey: true, allowNull: false, autoIncrement: true},
        uuid:{type: DataTypes.TEXT, allowNull:false},
        fired_at:{type: DataTypes.TEXT, allowNull:false},
        assignment:{type: DataTypes.JSON, allowNull:false},
        institution_abbreviation:{type: DataTypes.TEXT, allowNull:false},
        modality:{type: DataTypes.TEXT, allowNull:false}
    },
    {
        underscored: true,
        freezeTableName: true
    });
    return grade_receiver;
}