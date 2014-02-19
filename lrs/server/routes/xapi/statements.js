var log = require('../../libs/log')(module);

var statementService = require('../../services/statement');
var response = require('../../services/response');

module.exports = function(app) {

    app.put('/xapi/statements', function(req, res){
        response.res = res;

        var statementId = req.query.statementId;
        if(statementId == undefined){
            return response.error('Statement ID is not defined');
        }

        var receivedStatement = req.body;
        receivedStatement.id = statementId;

        statementService.storeIfNotExist(receivedStatement,
            response.statementPutOk.bind(response),
            response.statementConflict.bind(response),
            response.error.bind(response));
    });

    app.post('/xapi/statements', function(req, res){
        response.res = res;

        var statements = req.body;
        if(statements == undefined){
            return response.error('No statements specified');
        }

        if( statements.length > 0 ){
            return statementService.storeStatements(statements,
                response.statementsPostOk.bind(response),
                response.statementConflict.bind(response),
                response.error.bind(response));
        }
        return statementService.storeStatement(statements,
            response.statementPostOk.bind(response),
            response.statementConflict.bind(response),
            response.error.bind(response));
    });

    app.get('/xapi/statements', function(req, res){
        response.res = res;

        var limit = req.query.limit != undefined && req.query.limit < 50 && req.query.limit > 0 ? req.query.limit : 50;
        var searchOptions = statementService.prepareSearchOptions(req);
        console.log(searchOptions);
        statementService.findOneOrMore(searchOptions, limit, response.statementsFound.bind(response), response.error.bind(response));


    });

};

