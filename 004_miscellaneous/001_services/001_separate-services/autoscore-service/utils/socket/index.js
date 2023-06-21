const io = require('socket.io');
const db = require('../../models');
const autoscore = require('../autoscore')

let socketio;

const create_server = (httpServer) => {
    socketio = new io.Server(httpServer,{
        cors:'*'
    })
    socketio.on('connection',(socket) => {
        console.log(`Cliente connectado: ${socket.id}`);
    })
}

const emit = {
    push_new_grade_sending: (grade_sending) => {
        socketio.emit('new_grade_sending',grade_sending)
    },
    push_updated_grade_sending: async (grade_sending) =>{
        var grade_updated = await db.grade_sending.findByPk(grade_sending.id, {
            include: [db.process_status, db.grade_receiver, db.institution]
        })
        socketio.emit('push_updated_grade_sending',grade_updated)
    },
    push_cronjob_status: async () => {
        var cronjobs = await db.cronjob.findAll()
        socketio.emit('push_cronjob_status', cronjobs)
    }
}

module.exports = {
    create_server,
    emit
}