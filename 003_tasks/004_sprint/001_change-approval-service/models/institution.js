module.exports = (db,DataTypes) => {
    return db.define('institution',{
        id:{type: DataTypes.INTEGER, primaryKey: true, allowNull: false, autoIncrement: true},
        uuid:{type: DataTypes.TEXT, allowNull:false},
        name:{type: DataTypes.TEXT, allowNull:false},
        fullname:{type: DataTypes.TEXT, allowNull:false},
        abbreviation:{ type: DataTypes.TEXT, allowNull:false },
        domain:{ type: DataTypes.TEXT, allowNull:false },
        website:{ type: DataTypes.TEXT, allowNull:false },
        restPath:{ type: DataTypes.TEXT, allowNull:false },
        modality: { type: DataTypes.TEXT, allowNull:false },
        translations:{ type: DataTypes.JSON, allowNull:false },
        token:{ type: DataTypes.TEXT, allowNull:false },
        campus_uuid:{ type: DataTypes.TEXT, allowNull:true },
    },
    {
        underscored: true,
        freezeTableName: true
    });
}