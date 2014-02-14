var mongoose = require('../../libs/mongoose');

var Score = new mongoose.Schema({
    scaled:{
        type:Number,
        required:true
    },
    raw:{
        type:Number
    },
    min:{
        type:Number
    },
    max:{
        type:Number
    }
});

var ScoreModel = mongoose.model('Score', Score);
module.exports = ScoreModel;