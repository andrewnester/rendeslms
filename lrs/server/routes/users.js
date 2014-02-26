var log = require('../libs/log')(module);
var oauth2 = require('../libs/oauth2');
var UserModel = require('../models/user');
var ClientModel = require('../models/client');

module.exports = function(app, passport) {
    app.post('/xapi/users/register',  function(req, res, next){
        ClientModel.findOne({'clientId':req.body.clientId}, function(err, client){
            if(err) {
                log.error("There is no client with clientID - %s", req.body.clientId);
                return next(err);
            }

            var user = new UserModel({ username: req.body.username, password: req.body.password, clientId: req.body.clientId });
            user.save(function(err, user) {
                if(err) {
                    log.error("Error creating user - %s", req.body.username);
                    return next(err);
                }

                log.info("New user - %s", user.username);
                res.status(200);
                return res.send({ msg: 'Successfully created'});
            });
        });
    });

    app.all('/xapi/users/*', passport.authenticate('bearer', { session: false }));
};
