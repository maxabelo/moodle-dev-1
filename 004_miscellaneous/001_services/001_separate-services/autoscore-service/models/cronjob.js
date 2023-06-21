module.exports = (db,DataTypes) => {
    const cronjob = db.define('cronjob', {
        id:{type: DataTypes.INTEGER, primaryKey: true, allowNull: false, autoIncrement: true},
        title:{type: DataTypes.TEXT, allowNull:false},
        abbreviation:{type: DataTypes.TEXT, allowNull:false},
        running:{type: DataTypes.BOOLEAN, allowNull:false},
        nextRun:{type: DataTypes.TEXT, allowNull:false},
        icon:{type: DataTypes.TEXT, allowNull:false}
    },{
        underscored: true,
        freezeTableName: true
    });
    return cronjob
}