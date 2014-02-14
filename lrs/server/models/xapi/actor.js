var mongoose = require('../../libs/mongoose');

var Actor = new mongoose.Schema({
    objectType: {
        type: String,
        default: 'Agent'
    },
    name: {
        type:String
    },
    member:[Actor],
    mbox:{
        type:String
    },
    mbox_sha1sum:{
        type:String
    },
    openid:{
        type:String
    },
    account:{
        type: mongoose.Schema.Types.Mixed
    }
});

var ActorModel = mongoose.model('Actor', Actor);
module.exports = ActorModel;