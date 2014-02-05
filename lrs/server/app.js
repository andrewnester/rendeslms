/*************************************
 *
 *      Module definition block
 *
 *************************************/


var express = require('express')
  , routes = require('./routes')
  , http = require('http')
  , passport = require('passport');

var log = require('./libs/log')(module);
var mongoose = require('./libs/mongoose');
var config = require('./libs/config');
var errorHandlers = require('./libs/errorHandlers');
var oauth2 = require('./libs/oauth2');

var app = express();




/*************************************
 *
 *    Middlewares assigning block
 *
 *************************************/

app.configure(function(){
    app.set('port', config.get('port'));

    app.use(passport.initialize());
    app.use(express.bodyParser());
    app.use(express.methodOverride());
    app.use(express.cookieParser('your secret here'));
    app.use(express.session());
    app.use(app.router);

    app.use(errorHandlers.notFound);
    app.use(errorHandlers.serverError);

});

require('./libs/auth');


/*************************************
 *
 *          Routes block
 *
 *************************************/
app.post('/oauth/token', oauth2.token);
app.all('*', passport.authenticate('bearer', { session: false }));

app.get('/', routes.index);



/*************************************
 *
 *    Starting server block
 *
 *************************************/

http.createServer(app).listen(app.get('port'), function(){
  log.info("Express server listening on port " + app.get('port'));
});
