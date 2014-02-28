angular.module('quiz', []).
    factory('quizService', ['$http', function(http) {
        var QuizService = function(){
            this.questionOrder = null;
            this.questionIndex = 0;
            this.questions = [];
        };


        QuizService.prototype.order = function(successCallback){
            var that = this;
            http({method: 'GET', url: QuizConfig.baseUrl + '/order'}).
                success(function(data, status, headers, config) {
                    that.questionOrder = data.order != undefined ? data.order : [];
                    successCallback();
                }).
                error(function(data, status, headers, config) {
                    console.log('Error while loading order');
                });
        };

        QuizService.prototype.first = function(handler){
            var questionID = this.questionOrder[0];
            if(this.questions[questionID] != undefined){
                return handler.success(this.questions[questionID]);
            }

            this._loadQuestion(questionID, handler);
        };


        QuizService.prototype.next = function(handler){
            var questionID = this.questionOrder[++this.questionIndex];
            if(questionID == undefined){
                --this.questionIndex;
                return handler.end();
            }
            if(this.questions[questionID] != undefined){
                return handler.success(this.questions[questionID]);
            }

            this._loadQuestion(questionID, handler);
        };


        QuizService.prototype.prev = function(handler){
            var questionID = this.questionOrder[--this.questionIndex];
            if(questionID == undefined){
                ++this.questionIndex;
                return handler.end();
            }

            if(this.questions[questionID] != undefined){
                return handler.success(this.questions[questionID]);
            }

            this._loadQuestion(questionID, handler);
        };

        QuizService.prototype._loadQuestion = function(questionID, handler){
            var that = this;
            http({method: 'GET', url: QuizConfig.baseUrl + '/' + questionID + '/view' }).
                success(function(data, status, headers, config) {
                    data.question.form = QuizConfig.baseTemplateUrl + '/'+ data.question.type + '.html';
                    that.questions[questionID] = data.question;
                    handler.success(data.question);
                }).
                error(function(data, status, headers, config) {
                    console.log('error');
                });
        };

        QuizService.prototype.validate = function(questionID, answers, handler){
            var xsrf = $.param({answers: answers});
            http({
                method: 'POST',
                data: xsrf,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: QuizConfig.baseUrl + '/' + questionID + '/validate'}).
                success(function(data, status, headers, config) {
                    return data.isRight ? handler.right() : handler.wrong();
                }).
                error(function(data, status, headers, config) {
                    console.log('error');
                });
        };




        return new QuizService();
    }])
    .directive('checkList', function() {
        return {
            scope: {
                list: '=checkList',
                value: '@'
            },
            link: function(scope, elem, attrs) {
                console.log(scope);
                var handler = function(setup) {
                    var checked = elem.prop('checked');
                    var index = scope.list.indexOf(scope.value);

                    if (checked && index == -1) {
                        if (setup) elem.prop('checked', false);
                        else scope.list.push(scope.value);
                    } else if (!checked && index != -1) {
                        if (setup) elem.prop('checked', true);
                        else scope.list.splice(index, 1);
                    }
                };

                var setupHandler = handler.bind(null, true);
                var changeHandler = handler.bind(null, false);

                elem.bind('change', function() {
                    scope.$apply(changeHandler);
                });
                scope.$watch('list', setupHandler, true);
            }
        };
    });



var QuizHandlers = function($scope){
    this.scope = $scope;
};

QuizHandlers.prototype.success = function(question){
    this.scope.question = question;
    this.scope.loading = 'none';
    this.scope.display = 'block';
};

QuizHandlers.prototype.right = function(){
    this.scope.result =  'right';
    this.scope.resultText = 'It is right answer!';
};

QuizHandlers.prototype.wrong = function(){
    this.scope.result =  'wrong';
    this.scope.resultText = 'Ooooh, it is wrong :(';
};

QuizHandlers.prototype.end = function(){
    this.scope.loading = 'none';
    this.scope.display = 'block';
};

QuizHandlers.prototype.before = function(){
    this.scope.loading = 'block';
    this.scope.display = 'none';
};

function QuizQuestionCtrl($scope, quizService)
{
    $scope.answers = [];

    $scope.first = function() {
        var quizhandler = new QuizHandlers($scope);
        quizhandler.before();
        if(quizService.questionOrder == null){
            quizService.order(function(){
                quizService.first(quizhandler);
            });
        }else{
            quizService.first(quizhandler);
        }
    };

    $scope.next = function() {
        var quizhandler = new QuizHandlers($scope);
        quizhandler.before();
        quizService.next(quizhandler, function(){});
    };

    $scope.prev = function() {
        var quizhandler = new QuizHandlers($scope);
        quizhandler.before();
        quizService.prev(quizhandler, function(){});
    };

    $scope.validate = function(questionID, answers) {
        console.log(answers);
        var quizhandler = new QuizHandlers($scope);
        quizService.validate(questionID, answers, quizhandler);
    };


    $scope.answerForm = function(){
        var questionType = $scope.question.type;
        var questionHandler = new window[questionType]();
        return questionHandler.renderAnswerForm($scope.question);
    };

    $scope.toggleAnswers = function(answer) {
        var idx = $scope.answers.indexOf(answer);

        // is currently selected
        if (idx > -1) {
            $scope.answers.splice(idx, 1);
        }

        // is newly selected
        else {
            $scope.answers.push(answer);
        }
    };
}

QuizQuestionCtrl.$inject = ['$scope','quizService'];


