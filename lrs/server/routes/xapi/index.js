module.exports = function(app, passport) {

    app.all('/xapi/*', passport.authenticate('bearer', { session: false }));

    require('./activities')(app, passport);
    require('./agents')(app, passport);
    require('./statements')(app, passport);
};

