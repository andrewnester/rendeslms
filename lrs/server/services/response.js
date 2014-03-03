var log = require('../libs/log')(module);

function ResponseService(){}

ResponseService.prototype = {

    res:{},

    statementPutOk : function(statement){
        this.res.send(204, 'No Content');
    },

    statementPostOk : function(statement){
        var that = this;
        that.res.send(200, statement.uuid);
    },

    statementsPostOk : function(statements){
        var IDs = [];
        for(var i= 0, count=statements.length; i<count;i++){
            IDs.push(statements[i].uuid);
        }
        this.res.send(200, IDs);
    },

    statementsFound : function(statements){
        if(Object.prototype.toString.call( statements ) === '[object Array]'){
            for(var i= 0, count=statements.length; i<count;i++){
                statements[i] = this.prepareStatement(statements[i]);
            }
        }else{
            statements = this.prepareStatement(statements);
        }
        this.res.send(200, statements);
    },

    statementConflict: function(statement){
        log.error('Conflict statement: ' + statement.uuid);
        this.res.send(409, 'Conflict');
    },

    prepareStatement: function(statement)
    {
        statement = statement.toObject();
        statement.id = statement.uuid;
        delete statement.uuid;
        delete statement._id;
        delete statement.__v;
        delete statement.clientId;

        return statement;
    },

    error: function(err){
        log.error(err);
        this.res.send(400, 'Bad Request')
    }
};


module.exports = new ResponseService();