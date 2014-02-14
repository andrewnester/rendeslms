var mongoose = require('../../libs/mongoose');

var ActorModel = require('./actor');
var StatementModel = require('./statement');

var Context = new mongoose.Schema({
    registration:{
        type:String
    },
    instructor:{
        type:[ActorModel.Schema]
    },
    team:{
        type:[ActorModel.Schema]
    },
    contextActivities:{
        type:[mongoose.Schema.Types.Mixed]
    },
    revision:{
        type:String
    },
    platform:{
        type:String
    },
    language:{
        type:String
    },
    duration:{
        type:String
    },
    statement:{
        type: mongoose.Schema.Types.ObjectId,
        ref: 'StatementModel'
    },
    extensions:{
        type:[mongoose.Schema.Types.Mixed]
    }
});

var ContextModel = mongoose.model('Context', Context);
module.exports = ContextModel;
