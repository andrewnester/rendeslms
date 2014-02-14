var mongoose = require('../../libs/mongoose');

var Verb = new mongoose.Schema({
    id:{
        type: String,
        required: true
    },
    display:{
        type: mongoose.Schema.Types.Mixed
    }
});

var VerbModel = mongoose.model('Verb', Verb);
module.exports = VerbModel;