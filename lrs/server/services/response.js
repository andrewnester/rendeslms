var log = require('../libs/log')(module);

function ResponseService(){}

ResponseService.prototype = {

    res:{},

    statementPutOk : function(){
        this.res.send(204, 'No Content');
    },

    statementPostOk : function(statement){
        var that = this;
        that.res.send(200, statement._id.toString());
    },

    statementsPostOk : function(statements){
        var IDs = [];
        for(var i= 0, count=statements.length; i<count;i++){
            IDs.push(statements[i]._id.toString());
        }
        this.res.send(200, IDs);
    },

    statementConflict: function(statement){
        log.error('Conflict statement: ' + statement._id);
        this.res.send(409, 'Conflict');
    },

    error: function(err){
        log.error(err);
        this.res.send(400, 'Bad Request')
    }
};


module.exports = new ResponseService();