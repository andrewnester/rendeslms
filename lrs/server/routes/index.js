module.exports = function(app, passport) {
    require('./xapi/oauth/index')(app);
    require('./users')(app, passport);
    require('./xapi')(app, passport);
    require('./main')(app, passport);
};