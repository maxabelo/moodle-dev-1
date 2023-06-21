module.exports = (db,DataTypes) => {
    const process_status = db.define('process_status',{
        id:{type: DataTypes.INTEGER, primaryKey: true, allowNull: false, autoIncrement: true},
        uuid:{type: DataTypes.TEXT, allowNull:false},
        process:{type: DataTypes.TEXT, allowNull:false},
        process_abbreviation:{type: DataTypes.TEXT, allowNull:false}
    },
    {
        underscored: true,
        freezeTableName: true
    });
    return process_status;
}