/*************************************
 *
 *      Module definition block
 *
 *************************************/


var express = require('express')
  , routes = require('./routes')
  , http = require('http')
  , path = require('path');

var log = require('./libs/log')(module);
var mongoose = require('./libs/mongoose');
var config = require('./libs/config');
var errorHandlers = require('./libs/errorHandlers');

var auth = require('http-auth');
var basic = auth.basic({
    realm: "Simon Area.",
    file: __dirname + "/../users.htpasswd"
});
var app = express();



/*************************************
 *
 *    Middlewares assigning block
 *
 *************************************/



app.configure(function(){
    app.set('port', config.get('port'));

    app.use(auth.connect(basic));
    app.use(express.bodyParser());
    app.use(express.methodOverride());
    app.use(express.cookieParser('your secret here'));
    app.use(express.session());
    app.use(app.router);

    app.use(errorHandlers.notFound);
    app.use(errorHandlers.serverError);

});



/*************************************
 *
 *          Routes block
 *
 *************************************/

app.get('/', routes.index);

/*************************************
 *
 *    Starting server block
 *
 *************************************/


http.createServer(app).listen(app.get('port'), function(){
  log.info("Express server listening on port " + app.get('port'));
});
