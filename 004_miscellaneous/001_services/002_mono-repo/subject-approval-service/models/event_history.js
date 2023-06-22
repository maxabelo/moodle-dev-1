module.exports = (db,DataTypes) => {
    return db.define('event_history',{
        id:{type: DataTypes.INTEGER, primaryKey: true, allowNull: false, autoIncrement: true},
        uuid:{type: DataTypes.TEXT, allowNull:false},
        fired_at:{type: DataTypes.TEXT, allowNull:false},
        payload:{type: DataTypes.JSON, allowNull:false},
        institution_abbreviation:{type: DataTypes.TEXT, allowNull:false}
    },
    {
        underscored: true,
        freezeTableName: true
    });
}