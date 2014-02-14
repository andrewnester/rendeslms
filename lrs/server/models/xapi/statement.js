var mongoose = require('../../libs/mongoose');

var Statement = new mongoose.Schema({
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
    return (valueType == 'string' || (valueType  == 'object' && value.id != undefined));

}, 'Invalid verb');


StatementModel.schema.path('object').validate(function (value) {
    if(value == undefined){
        return false;
    }

    return !(value.id == undefined);

}, 'Invalid object');

module.exports = StatementModel;