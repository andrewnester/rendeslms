var log = require('./log')(module);

function notFoundHanler(req, res, next)
{
    res.status(404);
    log.debug('Not found URL: %s',req.url);
    res.send({ error: 'Not found' });
}

function serverErrorHanler(err, req, res, next)
{
    res.status(err.status || 500);
    log.error('Internal error(%d): %s', res.statusCode, err.message);
    res.send({ error: err.message });
}

module.exports.notFound = notFoundHanler;
module.exports.serverError = serverErrorHanler;