/**
 * load environment variables
 */
require('dotenv').config();

var rabbitmq = require('amqplib');
var eventProcessors = require('../eventProcessors')

let i = 0;//marco el ultimo mensaje que llego desde que se inicio/reinicio el servidor (por mera curiosidad)

let queue = process.env.RABBIT_QUEUE;

let channel;

/**
 * Inicia el servicio de rabbitmq
 * Las configuraciones se encuentran en .env
 */
exports.connect = async () => {
    const credentials = {credentials: rabbitmq.credentials.plain(process.env.RABBIT_USERNAME, process.env.RABBIT_PASSWORD)}
    const connection = await rabbitmq.connect(`${process.env.RABBIT_HOST}:${process.env.RABBIT_PORT}/${process.env.RABBIT_VHOST}`, credentials)

    channel = await connection.createConfirmChannel();

    await channel.assertExchange(process.env.RABBIT_EXCHANGE, process.env.RABBIT_TYPE_EXCHANGE)

    await channel.assertQueue(queue, {durable: true})

    await channel.bindQueue(queue, process.env.RABBIT_ROUTING_KEY, '')
}

/**
 * Consume todos los mensajes que llegan desde rabbitmq
 * valida los headers y properties de los mensajes descartando los que no estan configurados en los .env
 *
 */

exports.consume = async () => {

    const receivedConsume = await channel.consume(queue, async (msg) => {
        try {
            if (!checkHeaderType(msg)) {
                console.log(`Messages ignore with id: ${msg.properties.messageId}`);
                await channel.ack(msg);
                return;
            }
            await eventProcessors(JSON.parse(msg.content.toString()));
            console.log(`Messages recived with id: ${msg.properties.messageId}`);
            console.log(`Message received rabbit count: ${++i}`);
            await channel.ack(msg);
        } catch (error) {
            console.error("error processing event " + error.message);
        }
    });
    console.log("recived consumer: ", receivedConsume);
}

/**
 *
 * @param {object} msg
 * @returns boolean
 *
 * Chequea que la firma de los headers o propiedades sean iguales a las configuradas en los .env
 */

function checkHeaderType(msg) {
    return msg.properties?.type === process.env.RABBIT_SIGNATURE;
}
