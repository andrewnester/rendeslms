var log = require('./log')(module);

function notFoundHandler(req, res, next)
{
    res.status(404);
    log.debug('Not found URL: %s',req.url);
    res.send({ error: 'Not found' });
}

function serverErrorHandler(err, req, res, next)
{
    res.status(err.status || 500);
    log.error('Internal error(%d): %s', res.statusCode, err.message);
    res.send({ error: err.message });
}

module.exports.notFound = notFoundHandler;
module.exports.serverError = serverErrorHandler;