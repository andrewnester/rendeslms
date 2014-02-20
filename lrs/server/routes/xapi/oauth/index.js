var log = require('../../../libs/log')(module);
var oauth2 = require('../../../libs/oauth2');

module.exports = function(app) {
    app.post('/xapi/oauth/token', oauth2.token);

    app.post('/xapi/oauth/register', function(req, res){
        if(req.user == undefined){
            res.send('400', 'Bad Request');
        }

        var parsedUser = JSON.parse(req.user);
        if(!parsedUser){
            res.send('400', 'Bad Request');
        }

        var user = new UserModel(parsedUser);
        user.save(function(err, user) {
            if(err) {
                log.error(err);
                res.send('400', 'Bad Request');
            }
            log.info("New user - %s:%s",user.username,user.password);
            res.send('200', 'Ok');
        });

    });
};
