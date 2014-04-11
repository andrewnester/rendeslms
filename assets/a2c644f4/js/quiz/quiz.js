angular.module('quiz', []).
    factory('quizService', ['$http', function(http) {
        var QuizService = function(){
            this.questionOrder = null;
            this.questionIndex = 0;
            this.questions = [];
        };

        QuizService.prototype.serialize = function(obj) {
            var str = [];
            for(var p in obj)
                if (obj.hasOwnProperty(p)) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
            return str.join("&");
        };


        QuizService.prototype.order = function(successCallback){
            var that = this;
            http({method: 'GET', url: QuizConfig.baseUrl + '/questionorder'}).
                success(function(data, status, headers, config) {
                    that.questionOrder = data.order != undefined ? data.order : [];
                    successCallback();
                }).
                error(function(data, status, headers, config) {
                    console.log('Error while loading order');
                });
        };


        QuizService.prototype.first = function(handler){
            handler.before();
            var questionID = this.questionOrder[0];
            if(this.questions[questionID] != undefined){
                return handler.success(this.questions[questionID]);
            }

            this._loadQuestion(questionID, handler);
        };


        QuizService.prototype.next = function(handler){
            handler.before();
            var questionID = this.questionOrder[++this.questionIndex];
            if(questionID == undefined){
                this.questionIndex = 0;
                return handler.success(this.questions[this.questionOrder[0]]);
            }
            if(this.questions[questionID] != undefined){
                return handler.success(this.questions[questionID]);
            }

            this._loadQuestion(questionID, handler);
        };


        QuizService.prototype.prev = function(handler){
            handler.before();
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
                    if(data.answered == true){
                        that.questions[questionID].doneEarlier = true;
                    }
                    handler.success(that.questions[questionID]);
                }).
                error(function(data, status, headers, config) {
                    console.log('error');
                });
        };


        QuizService.prototype.validate = function(questionID, answers, handler){
            var xsrf = this.serialize({answers: answers});
            var that = this;
            http({
                method: 'POST',
                data: xsrf,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: QuizConfig.baseUrl + '/' + questionID + '/validate'}).
                success(function(data, status, headers, config) {
                    setTimeout(function(){
                        that.next(handler);
                    }, 1000);

                    that.questions[questionID].done = true;
                    that.questions[questionID].answers = answers;
                    if(!data.isRight){
                        that.questions[questionID].result =  'wrong';
                        that.questions[questionID].resultText = 'Ooooh, it is wrong :(';
                    }else{
                        that.questions[questionID].result =  'right';
                        that.questions[questionID].resultText = 'It is right answer!';
                    }
                    return data.isRight;
                }).
                error(function(data, status, headers, config) {
                    console.log('error');
                });
        };


        QuizService.prototype.totalQuestions = function(){
            if(this.questionOrder == undefined){
                return 0;
            }
            return this.questionOrder.length;
        };

        QuizService.prototype.totalAnsweredQuestions = function(){
            if(this.questionOrder == undefined){
                return 0;
            }

            var answered = 0;
            for(var i=0, count=this.questionOrder.length; i<count;i++){
                if(this.questions[this.questionOrder[i]] !=undefined && this.questions[this.questionOrder[i]].done){
                    answered++;
                }
            }

            return answered;
        };

        QuizService.prototype.totalRightAnswers = function(){
            if(this.questionOrder == undefined){
                return 0;
            }

            var rightAnswered = 0;
            for(var i=0, count=this.questionOrder.length; i<count;i++){
                if(this.questions[this.questionOrder[i]] !=undefined && this.questions[this.questionOrder[i]].result == 'right'){
                    rightAnswered++;
                }
            }

            return rightAnswered;
        };

        return new QuizService();
    }]);



var QuizHandlers = function($scope){
    this.scope = $scope;
};

QuizHandlers.prototype.success = function(question){
    this.scope.question = question;
    this.scope.loading = 'none';
    this.scope.display = 'block';
};

QuizHandlers.prototype.end = function(){
    this.scope.loading = 'none';
    this.scope.display = 'block';
};

QuizHandlers.prototype.before = function(){
    this.scope.answers = [];
    this.scope.loading = 'block';
    this.scope.display = 'none';
};

function QuizQuestionCtrl($scope, quizService)
{
    $scope.answers = [];

    $scope.first = function() {
        var quizhandler = new QuizHandlers($scope);
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
        quizService.next(quizhandler, function(){});
    };

    $scope.prev = function() {
        var quizhandler = new QuizHandlers($scope);
        quizService.prev(quizhandler, function(){});
    };

    $scope.validate = function(questionID, answers) {
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
        if (idx > -1) {
            $scope.answers.splice(idx, 1);
        }
        else {
            $scope.answers.push(answer);
        }
    };

    $scope.checkedAnswers = function() {
        return $scope.answers;
    };

    $scope.finishQuiz = function() {
        $scope.endQuiz = true;
    };

    $scope.totalQuestions = function(){
        return quizService.totalQuestions();
    };

    $scope.totalAnsweredQuestions = function(){
        return quizService.totalAnsweredQuestions();
    };

    $scope.totalRightAnswers = function(){
        return quizService.totalRightAnswers();
    }
}

QuizQuestionCtrl.$inject = ['$scope','quizService'];


