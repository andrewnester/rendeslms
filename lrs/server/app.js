/*************************************
 *
 *      Module definition block
 *
 *************************************/


var express = require('express');

var app = express();
var passport = require('passport');
var http = require('http');


var log = require('./libs/log')(module);
var mongoose = require('./libs/mongoose');
var config = require('./libs/config');
var errorHandlers = require('./libs/errorHandlers');




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

var routes = require('./routes')(app, passport);
require('./libs/auth');


/*************************************
 *
 *          Routes block
 *
 *************************************/


/*************************************
 *
 *    Starting server block
 *
 *************************************/

http.createServer(app).listen(app.get('port'), function(){
  log.info("Express server listening on port " + app.get('port'));
});
