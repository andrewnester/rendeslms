var log = require('../../libs/log')(module);

var StatementService = require('../../services/statement');
var ResponseService = require('../../services/response');

module.exports = function(app) {

    app.put('/xapi/statements', function(req, res){
        ResponseService.res = res;

        var statementId = req.query.statementId;
        if(statementId == undefined){
            return ResponseService.error('Statement ID is not defined');
        }

        var receivedStatement = req.body;
        receivedStatement.id = statementId;

        StatementService.storeIfNotExist(receivedStatement,
            ResponseService.statementPutOk.bind(ResponseService),
            ResponseService.statementConflict.bind(ResponseService),
            ResponseService.error.bind(ResponseService));
    });

    app.post('/xapi/statements', function(req, res){
        ResponseService.res = res;

        var statements = req.body;
        if(statements == undefined){
            return ResponseService.error('No statements specified');
        }

        if( statements.length > 0 ){
            return StatementService.storeStatements(statements,
                ResponseService.statementsPostOk.bind(ResponseService),
                ResponseService.statementConflict.bind(ResponseService),
                ResponseService.error.bind(ResponseService));
        }
        return StatementService.storeStatement(statements,
            ResponseService.statementPostOk.bind(ResponseService),
            ResponseService.statementConflict.bind(ResponseService),
            ResponseService.error.bind(ResponseService));
    });

};

