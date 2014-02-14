var log = require('../libs/log')(module);
var oauth2 = require('../libs/oauth2');
var UserModel = require('../models/user');

module.exports = function(app, passport) {
    app.post('/users/register',  function(req, res, next){
        var user = new UserModel({ username: req.body.username, password: req.body.password });
        user.save(function(err, user) {
            if(err) {
                return next(err);
            }
            res.status(200);
            log.info("New user - %s:%s", user.username,user.password);
            return res.send({ msg: 'Successfully created'});
        });
    });

    app.all('/users/*', passport.authenticate('bearer', { session: false }));
};
