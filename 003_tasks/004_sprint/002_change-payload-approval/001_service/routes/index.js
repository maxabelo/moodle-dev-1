var express = require('express');
var router = express.Router();

router.get('/', (req,res) => {
    res.send("service up!!")
});

module.exports = router;
