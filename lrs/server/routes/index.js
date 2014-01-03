
/*
 * GET home page.
 */

var log = require('../libs/log')(module);

exports.index = function(req, res){
    res.status(200);
    return res.send({ msg: 'All is ok' });
};