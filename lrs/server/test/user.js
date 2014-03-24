var UserModel = require('../models/user');
var mongoose = require('../libs/mongoose');

describe('UserModel', function () {
    it('Должно быть моделью mongoose', function () {
        UserModel.should.be.have.property('model');
        UserModel.should.be.have.property('schema');
    });


});