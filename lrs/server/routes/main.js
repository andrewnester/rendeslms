var log = require('../libs/log')(module);
var oauth2 = require('../libs/oauth2');

module.exports = function(app, passport) {

    app.all('*', passport.authenticate('bearer', { session: false }));

    app.get('/', function(req, res){
        res.status(200);
        return res.send({ msg: 'All is ok' });
    });
};
