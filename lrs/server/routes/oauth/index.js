var log = require('../../libs/log')(module);
var oauth2 = require('../../libs/oauth2');

module.exports = function(app) {
    app.post('/oauth/token', oauth2.token);
};
