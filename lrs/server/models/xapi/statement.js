var mongoose = require('../../libs/mongoose');

var Statement = new mongoose.Schema({
    clientId:{
        type: String,
        required: true
    },
    actor:{
        type: mongoose.Schema.Types.Mixed,
        required:true
    },
    verb:{
        type: mongoose.Schema.Types.Mixed,
        required: true
    },
    object:{
        type: mongoose.Schema.Types.Mixed,
        required: true
    },
    result:{
        type: mongoose.Schema.Types.Mixed
    },
    context:{
        type: mongoose.Schema.Types.Mixed
    },
    timestamp:{
        type: Date
    },
    stored:{
        type: Date,
        default: Date.now
    },
    authority:{
        type: mongoose.Schema.Types.Mixed
    },
    attachments:[{}]
});


var StatementModel = mongoose.model('Statement', Statement);





/**************************************************************************************************************
 *
 *
 *                                              VALIDATION RULES
 *
 *
 **************************************************************************************************************/




StatementModel.schema.path('actor').validate(function (value) {
    if(value == undefined){
        return false;
    }

    return !(value.mbox == undefined && value.mbox == undefined && value.openId == undefined);

}, 'Invalid actor');

StatementModel.schema.path('verb').validate(function (value) {
    if(value == undefined){
        return false;
    }

    var valueType = (typeof value);
    return (valueType  == 'object' && value.id != undefined);

}, 'Invalid verb');

StatementModel.schema.path('object').validate(function (value) {
    if(value == undefined){
        return false;
    }

    return !(value.id == undefined);

}, 'Invalid object');

StatementModel.schema.path('result').validate(function (value) {
    if(value == undefined){
        return true;
    }

    if(value.score != undefined){
        if(value.score.scaled != undefined){
            if(value.score.scaled > 1 || value.score.scaled < -1){
                return false
            }
        }

        if(value.score.min != undefined && value.score.max != undefined){
            if(value.score.min > value.score.max){
                return false;
            }
        }
    }

    if(value.success != undefined){
        if(typeof value.success != 'boolean' ){
            return false;
        }
    }

    if(value.completion != undefined){
        if(typeof value.completion != 'boolean' ){
            return false;
        }
    }

    //TODO : duration validation

    return true;

}, 'Invalid result');

StatementModel.schema.path('context').validate(function (value) {
    if(value == undefined){
        return true;
    }

    //TODO : context fields validation

    return true;

}, 'Invalid context');

/**************************************************************************************************************
 *
 *
 *                                              END VALIDATION RULES
 *
 *
 **************************************************************************************************************/


module.exports = StatementModel;