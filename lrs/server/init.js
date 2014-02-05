var log                 = require('./libs/log')(module);
var mongoose            = require('./libs/mongoose').mongoose;
var UserModel               = require('./models/user');
var ClientModel             = require('./models/client');
var AccessTokenModel        = require('./models/accessToken');
var RefreshTokenModel        = require('./models/refreshToken');

UserModel.remove({}, function(err) {
    var user = new UserModel({ username: "andrey", password: "simplepassword" });
    user.save(function(err, user) {
        if(err) return log.error(err);
        else log.info("New user - %s:%s",user.username,user.password);
    });

    for(i=0; i<4; i++) {
        var user = new UserModel({ username: "andrey"+i, password: "simplepassword"+i });
        user.save(function(err, user) {
            if(err) return log.error(err);
            else log.info("New user - %s:%s",user.username,user.password);
        });
    }
});

ClientModel.remove({}, function(err) {
    var client = new ClientModel({ name: "OurService iOS client v1", clientId: "mobileV1", clientSecret:"abc123456" });
    client.save(function(err, client) {
        if(err) return log.error(err);
        else log.info("New client - %s:%s",client.clientId,client.clientSecret);
    });
});
AccessTokenModel.remove({}, function (err) {
    if (err) return log.error(err);
});
RefreshTokenModel.remove({}, function (err) {
    if (err) return log.error(err);
});

setTimeout(function() {
    mongoose.disconnect();
}, 3000);
