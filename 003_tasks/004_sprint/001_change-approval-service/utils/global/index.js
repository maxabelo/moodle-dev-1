const makeIdNumberCourse = (uuid,version) => {
    return uuid + "||"+ version
}

module.exports = {
    makeIdNumberCourse
}