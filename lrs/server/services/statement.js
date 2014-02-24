var StatementModel = require('../models/xapi/statement');
var log = require('../libs/log')(module);

function StatementService(){}

StatementService.prototype = {

    storeIfNotExist: function(user, statement, success, exist, error)
    {
        var that = this;
        StatementModel.findOne({'_id':statement.id}, function(err, foundStatement){
            if(foundStatement){
                if(that.compareStatements(foundStatement, statement)){
                    return success(foundStatement);
                }else{
                    return exist(foundStatement);
                }
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
            'clientId': req.user.clientId,
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
    },

    compareStatements: function(statement1, statement2)
    {

        if(JSON.stringify(this.sortObject(statement1.actor)) != JSON.stringify(this.sortObject(statement2.actor))){
            return false;
        }

        if(JSON.stringify(this.sortObject(statement1.verb)) != JSON.stringify(this.sortObject(statement2.verb))){
            return false;
        }

        if(JSON.stringify(this.sortObject(statement1.object)) != JSON.stringify(this.sortObject(statement2.object))){
            return false;
        }

        if(JSON.stringify(this.sortObject(statement1.result)) != JSON.stringify(this.sortObject(statement2.result))){
            return false;
        }

        if(JSON.stringify(this.sortObject(statement1.context)) != JSON.stringify(this.sortObject(statement2.context) )){
            return false;
        }

        if(JSON.stringify(this.sortObject(statement1.timestamp)) != JSON.stringify(this.sortObject(statement2.timestamp))){
            return false;
        }

        if(JSON.stringify(this.sortObject(statement1.authority)) != JSON.stringify(this.sortObject(statement2.authority))){
            return false;
        }

        if(JSON.stringify(this.sortObject(statement1.attachments)) != JSON.stringify(this.sortObject(statement2.attachments))){
            return false;
        }

        return true;
    },

    sortObject: function(obj)
    {
        if(obj == undefined){
            return {};
        }

        var keys = Object.keys(obj),
            len = keys.length, sortedObj = {};

        keys.sort();
        for (var i = 0; i < len; i++){
            sortedObj[keys[i]] = obj[keys[i]];
        }

        return sortedObj;
    }


};

module.exports = new StatementService();