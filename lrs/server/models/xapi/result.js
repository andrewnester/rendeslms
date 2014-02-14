var mongoose = require('../../libs/mongoose');

var ScoreModel = require('./score');

var Result = new mongoose.Schema({
    score:{
        type:[ScoreModel.Schema]
    },
    success:{
        type:Boolean
    },
    completion:{
        type:Boolean
    },
    response:{
        type:String
    },
    duration:{
        type:String
    },
    extensions:{
        type:[mongoose.Schema.Types.Mixed]
    }
});

var ResultModel = mongoose.model('Result', Result);
module.exports = ResultModel;