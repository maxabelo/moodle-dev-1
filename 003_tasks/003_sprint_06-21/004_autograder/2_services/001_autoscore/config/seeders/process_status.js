var uuid = require('uuid')

module.exports = [{
        uuid: uuid.v4(),
        process: 'Waiting to send',
        process_abbreviation: 'WAITING_TO_SEND',
        created_at: new Date(),
        updated_at: new Date()
    },
    {
        uuid: uuid.v4(),
        process: 'Updated',
        process_abbreviation: 'UPDATED',
        created_at: new Date(),
        updated_at: new Date()
    },
    {
        uuid: uuid.v4(),
        process: 'Internal error',
        process_abbreviation: 'INTERNAL_ERROR',
        created_at: new Date(),
        updated_at: new Date()
    },
    {
        uuid: uuid.v4(),
        process: 'Sended to moodle',
        process_abbreviation: 'SENDED',
        created_at: new Date(),
        updated_at: new Date()
    },
    {
        uuid: uuid.v4(),
        process: 'Successful scored to moodle',
        process_abbreviation: 'SUCCESSFUL_MOODLE',
        created_at: new Date(),
        updated_at: new Date()
    },
    {
        uuid: uuid.v4(),
        process: 'Moodle error',
        process_abbreviation: 'MOODLE_ERROR',
        created_at: new Date(),
        updated_at: new Date()
    },
    {
        uuid: uuid.v4(),
        process: 'Existing grade',
        process_abbreviation:'EXISTING_GRADE',
        created_at: new Date(),
        updated_at: new Date()
    },
    {
        uuid: uuid.v4(),
        process: 'Processing',
        process_abbreviation:'PROCESSING',
        created_at: new Date(),
        updated_at: new Date()
    },
    {
        uuid: uuid.v4(),
        process: 'User not found',
        process_abbreviation:'USER_NOT_FOUND',
        created_at: new Date(),
        updated_at: new Date()
    }
]