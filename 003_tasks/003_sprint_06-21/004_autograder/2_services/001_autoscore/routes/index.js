var express = require('express');
var router = express.Router();
var autoscore_functions = require("../utils/autoscore");
const moodle = require('../utils/moodle');
const global = require("../utils/global")
const cron = require("../utils/cron")


router.get('/autoscores', async (req,res) => {
    var response_util = await autoscore_functions.get_autoscore(req.query)
    res.send(response_util)
})

router.get('/autoscores/institution/:abbreviation', (req,res) => {
    var response_util = autoscore_functions.get_autoscore()
    res.send(response_util)
})

router.get('/autoscore/:uuid', async (req,res) => {
    var response_util = await autoscore_functions.get_autoscore_by_uuid(req.params.uuid)
    res.send(response_util)
})

router.get('/institutions', async (req,res) => {
    var response = await global.get_institutions()
    res.send(response)
})

router.get('/process_status', async (req,res) => {
    var response = await global.get_all_process_status()
    res.send(response)
})

router.get('/crons',async(req,res)=>{
    var response = await cron.get_crons()
    res.send(response)
})

router.get('/cronjob_autoscore', async(req,res) => {
    var cron_response = await cron.run_autoscore_cronjob()
    res.send(cron_response)
})

router.get('/cleaner_cronjob', async(req,res) => {
    var cron_response = await cron.run_autoscore_cleaner()
    res.send(cron_response)
})
module.exports = router;
