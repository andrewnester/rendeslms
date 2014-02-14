module.exports = function(app, passport) {
    require('./oauth/index')(app);
    require('./users')(app, passport);
    require('./xapi')(app, passport);
    require('./main')(app, passport);
};