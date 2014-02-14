var StatementModel = require('../models/xapi/statement');
var log = require('../libs/log')(module);
function StatementService(){}

StatementService.prototype = {
    storeIfNotExist: function(statement, success, exist, error)
    {
        var that = this;
        StatementModel.findById(statement.id, function(err, foundStatement){
            if(foundStatement){
                return exist(foundStatement);
            }

            var statementObject = that.prepare(statement);
            return statementObject.save(function (err, statement) {
                    if (err){
                        return error(err);
                    }
                    return success(statement);
                }
            )
        });
    },

    storeStatements: function(statements, success, exist, error)
    {
        var total = statements.length;
        var that = this;
        var storedStatements = [];

        function _stored(statement)
        {
            storedStatements.push(statement);
            if (--total) {
                return that.storeStatement(statements.pop(), _stored, exist, error)
            }
            else{
                return success(storedStatements);
            }
        }


        var statement = statements.pop();
        this.storeStatement(statement, _stored, exist, error);
    },


    storeStatement: function(statement, success, exist, error)
    {
        if(statement.id != undefined){
            return this.storeIfNotExist(statement, success, exist, error);
        }

        var statementObject = this.prepare(statement);
        return statementObject.save(function (err, statement) {
                if (err){
                    return error(err);
                }
                return success(statement);
            }
        )
    },

    prepare: function(statement)
    {
        if(statement.id != undefined){
            statement._id = statement.id;
        }
        return new StatementModel(statement);
    }
};

module.exports = new StatementService();