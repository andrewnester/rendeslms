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

        QuizService.prototype.first = function(successCallback){
            var questionID = this.questionOrder[0];
            if(this.questions[questionID] != undefined){
                return successCallback(this.questions[questionID]);
            }

            this._loadQuestion(questionID, successCallback);
        };


        QuizService.prototype.next = function(successCallback, endCallback){
            var questionID = this.questionOrder[++this.questionIndex];
            if(questionID == undefined){
                return endCallback();
            }
            if(this.questions[questionID] != undefined){
                return successCallback(this.questions[questionID]);
            }

            this._loadQuestion(questionID, successCallback);
        };


        QuizService.prototype.prev = function(successCallback, endCallback){
            var questionID = this.questionOrder[--this.questionIndex];
            if(questionID == undefined){
                return endCallback();
            }

            if(this.questions[questionID] != undefined){
                return successCallback(this.questions[questionID]);
            }

            this._loadQuestion(questionID, successCallback);
        };

        QuizService.prototype._loadQuestion = function(questionID, successCallback){
            var that = this;
            http({method: 'GET', url: QuizConfig.baseUrl + '/' + questionID + '/view' }).
                success(function(data, status, headers, config) {
                    data.question.form = QuizConfig.baseTemplateUrl + '/'+ data.question.type + '.html';
                    that.questions[questionID] = data.question;
                    successCallback(data.question);
                }).
                error(function(data, status, headers, config) {
                    console.log('error');
                });
        };

        QuizService.prototype.validate = function(questionID, answers){
            http({method: 'GET', url: QuizConfig.baseUrl + '/' + questionID + '/validate'}).
                success(function(data, status, headers, config) {
                    console.log(data);
                }).
                error(function(data, status, headers, config) {
                    console.log(data);
                    console.log('error');
                });
        };




        return new QuizService();
    }]);



function QuizQuestionCtrl($scope, quizService)
{
    $scope.first = function() {
        if(quizService.questionOrder == null){
            quizService.order(function(){
                quizService.first(function(question){
                    $scope.question = question
                });
            });
        }else{
            quizService.first(function(question){
                $scope.question = question
            });
        }
    };

    $scope.next = function() {
        quizService.next(
            function(question){
                $scope.question = question
            },
            function(){

            });
    };

    $scope.prev = function() {
         quizService.prev(
            function(question){
                $scope.question = question
            },
            function(){

            });
    };


    $scope.answerForm = function(){
        var questionType = $scope.question.type;
        var questionHandler = new window[questionType]();
        return questionHandler.renderAnswerForm($scope.question);
    }
}

QuizQuestionCtrl.$inject = ['$scope','quizService'];
