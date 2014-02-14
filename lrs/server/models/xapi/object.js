var mongoose = require('../../libs/mongoose');

var Object = new mongoose.Schema({
    objectType:{
        type: String
    },
    id:{
        type: String,
        required: true
    },
    definition:{
        type: mongoose.Schema.Types.Mixed
    }
});

var ObjectModel = mongoose.model('Object', Object);
module.exports = ObjectModel;