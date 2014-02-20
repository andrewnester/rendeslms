var StatementModel = require('../models/xapi/statement');
var log = require('../libs/log')(module);

function StatementService(){}

StatementService.prototype = {

    storeIfNotExist: function(user, statement, success, exist, error)
    {
        var that = this;
        StatementModel.findOne({'id':statement.id, 'clientId': user.clientId}, function(err, foundStatement){
            if(foundStatement){
                return exist(foundStatement);
            }

            var statementObject = that.prepare(user, statement);
            return statementObject.save(function (err, statement) {
                    if (err){
                        return error(err);
                    }
                    return success(statement);
                }
            )
        });
    },

    storeStatements: function(user, statements, success, exist, error)
    {
        var total = statements.length;
        var that = this;
        var storedStatements = [];

        function _stored(statement)
        {
            storedStatements.push(statement);
            if (--total) {
                return that.storeStatement(user, statements.pop(), _stored, exist, error)
            }
            else{
                return success(storedStatements);
            }
        }


        var statement = statements.pop();
        this.storeStatement(user, statement, _stored, exist, error);
    },

    storeStatement: function(user, statement, success, exist, error)
    {
        if(statement.id != undefined){
            return this.storeIfNotExist(user, statement, success, exist, error);
        }

        var statementObject = this.prepare(user, statement);
        return statementObject.save(function (err, statement) {
                if (err){
                    return error(err);
                }
                return success(statement);
            }
        )
    },

    prepare: function(user, statement)
    {
        statement['clientId'] = user.clientId;
        if(statement.id != undefined){
            statement._id = statement.id;
        }
        return new StatementModel(statement);
    },

    prepareSearchOptions: function(req)
    {

        searchOptions = {
            'verb.id':{'$ne': 'http://www.adlnet.gov/XAPIprofile/voided'}
        };

        if(req.query.statementId != undefined){
            searchOptions._id = req.query.statementId;
        }

        if(req.query.voidedStatementId != undefined){
            searchOptions._id = req.query.voidedStatementId;
            searchOptions['verb.id'] = 'http://www.adlnet.gov/XAPIprofile/voided';
        }

        if(req.query.activity != undefined){
            if(req.query.related_activities == true){
                searchOptions.$or = [
                    {'object.contextActivities': {$elemMatch : {id: req.query.activity}}},
                    {'$and':[{'object.objectType':'Activity'}, {'object.id':req.query.activity}]},
                    {'$and':[{'object.objectType':'SubDocument'}, {'object.id':req.query.activity}]}
                ];
            }else{
                searchOptions['object.objectType'] = 'Activity';
                searchOptions['object.id'] = req.query.activity;
            }
        }

        if(req.query.verb != undefined){
            searchOptions['verb.id'] = req.query.verb;
        }

        if(req.query.agent != undefined){
            var matchedAgent = {'actor':{}, 'object':{}, 'authority':{}, 'instructor':{}, 'object.actor':{}, 'object.object':{}, 'object.authority':{}, 'object.instructor':{} };
            var agent = JSON.parse(req.query.agent);
            for(var field in agent){
                matchedAgent['actor']['actor.'+field] = agent[field];
                matchedAgent['object']['object.'+field] = agent[field];
                matchedAgent['authority']['authority.'+field] = agent[field];
                matchedAgent['instructor']['instructor.'+field] = agent[field];
                matchedAgent['object.actor']['object.actor.'+field] = agent[field];
                matchedAgent['object.object']['object.object.'+field] = agent[field];
                matchedAgent['object.authority']['object.authority.'+field] = agent[field];
                matchedAgent['object.instructor']['object.instructor.'+field] = agent[field];
            }
            if(req.query.related_activities == true){
                searchOptions.$or = [
                    matchedAgent['actor'],
                    matchedAgent['object'],
                    matchedAgent['authority'],
                    matchedAgent['instructor'],
                    matchedAgent['object.actor'],
                    matchedAgent['object.object'],
                    matchedAgent['object.authority'],
                    matchedAgent['object.instructor']
                ];
            }else{
                searchOptions.$or = [
                    matchedAgent['actor'],
                    matchedAgent['object']
                ];
            }
        }

        if(req.query.registration != undefined){
            searchOptions['context.registration'] = req.query.registration;
        }



        return searchOptions;
    },

    findOneOrMore: function(user, options, limit, success, error)
    {
        StatementModel.find(options, {}, {limit: limit}, function(err, statements){
           if(err){
               return error(err);
           }
           if(statements.length == 1){
               return success(statements[0]);
           }else{
               return success(statements);
           }
        }).limit(limit);
    }
};

module.exports = new StatementService();