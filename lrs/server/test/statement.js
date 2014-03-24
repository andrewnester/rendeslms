var StatementModel = require('../models/xapi/statement');
var mongoose = require('../libs/mongoose');

describe('StatementModel', function () {
    it('Должно быть моделью mongoose', function () {
        StatementModel.should.be.have.property('model');
        StatementModel.should.be.have.property('schema');
    });

    it('Схема объекта должна соответствовать стандарту Tin Can API', function () {
        var paths = StatementModel.schema.paths;
        paths.should.be.have.property('actor');
        paths.should.be.have.property('verb');
        paths.should.be.have.property('object');
        paths.should.be.have.property('uuid');
        paths.should.be.have.property('result');
        paths.should.be.have.property('context');
        paths.should.be.have.property('timestamp');
        paths.should.be.have.property('stored');
        paths.should.be.have.property('authority');
    });

    it('Поле actor объекта запсии должно соответствовать стандарту Tin Can API', function () {
        var paths = StatementModel.schema.paths;
        paths.actor.options.type.should.equal(mongoose.Schema.Types.Mixed);
        paths.actor.options.required.should.equal(true);
    });

    it('Поле uuid объекта запсии должно соответствовать стандарту Tin Can API', function () {
        var paths = StatementModel.schema.paths;
        paths.uuid.options.type.should.equal(String);
        paths.uuid.options.required.should.equal(true);
    });

    it('Поле verb объекта запсии должно соответствовать стандарту Tin Can API', function () {
        var paths = StatementModel.schema.paths;
        paths.verb.options.type.should.equal(mongoose.Schema.Types.Mixed);
        paths.verb.options.required.should.equal(true);
    });

    it('Поле object объекта запсии должно соответствовать стандарту Tin Can API', function () {
        var paths = StatementModel.schema.paths;
        paths.object.options.type.should.equal(mongoose.Schema.Types.Mixed);
        paths.object.options.required.should.equal(true);
    });

    it('Поле result объекта запсии должно соответствовать стандарту Tin Can API', function () {
        var paths = StatementModel.schema.paths;
        paths.result.options.type.should.equal(mongoose.Schema.Types.Mixed);
    });

    it('Поле context объекта запсии должно соответствовать стандарту Tin Can API', function () {
        var paths = StatementModel.schema.paths;
        paths.context.options.type.should.equal(mongoose.Schema.Types.Mixed);
    });

    it('Поле timestamp объекта запсии должно соответствовать стандарту Tin Can API', function () {
        var paths = StatementModel.schema.paths;
        paths.timestamp.options.type.should.equal(Date);
    });

    it('Поле stored объекта запсии должно соответствовать стандарту Tin Can API', function () {
        var paths = StatementModel.schema.paths;
        paths.stored.options.type.should.equal(Date);
        paths.stored.options.default.should.equal(Date.now);
    });

    it('Поле authority объекта запсии должно соответствовать стандарту Tin Can API', function () {
        var paths = StatementModel.schema.paths;
        paths.authority.options.type.should.equal(mongoose.Schema.Types.Mixed);
    });

    it('Объект записи должен содержать ID клиента, которому он принадлежит', function () {
        var paths = StatementModel.schema.paths;
        paths.clientId.options.type.should.equal(String);
        paths.clientId.options.required.should.equal(true);
    });

    it('Поле actor должно валидировать данные согласно стандарту Tin Can API', function(){
        var validators = StatementModel.schema.path('actor').validators;
        var validationWrongObjectResult = true;
        var validationRightObjectResult = true;
        for(var i= 0, count = validators.length; i<count; i++){
            var validator = validators[i][0];
            validationWrongObjectResult = validationWrongObjectResult && validator({email: 'some_email'});
            validationRightObjectResult = validationRightObjectResult && validator({mbox: 'andrew.nester.dev@gmail.com'});
        }

        validationRightObjectResult.should.be.equal(true);
        validationWrongObjectResult.should.be.equal(false);
    });

    it('Поле verb должно валидировать данные согласно стандарту Tin Can API', function(){
        var validators = StatementModel.schema.path('verb').validators;
        var validationWrongObjectResult = true;
        var validationRightObjectResult = true;
        for(var i= 0, count = validators.length; i<count; i++){
            var validator = validators[i][0];
            validationWrongObjectResult = validationWrongObjectResult && validator({not_id: '123456'});
            validationRightObjectResult = validationRightObjectResult && validator({id: '123456'});
        }

        validationRightObjectResult.should.be.equal(true);
        validationWrongObjectResult.should.be.equal(false);
    });

    it('Поле object должно валидировать данные согласно стандарту Tin Can API', function(){
        var validators = StatementModel.schema.path('object').validators;
        var validationWrongObjectResult = true;
        var validationRightObjectResult = true;
        for(var i= 0, count = validators.length; i<count; i++){
            var validator = validators[i][0];
            validationWrongObjectResult = validationWrongObjectResult && validator({not_id: '123456'});
            validationRightObjectResult = validationRightObjectResult && validator({id: '123456'});
        }

        validationRightObjectResult.should.be.equal(true);
        validationWrongObjectResult.should.be.equal(false);
    });

});