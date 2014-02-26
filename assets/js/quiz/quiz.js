angular.module('quiz', []).
    factory('quizService', ['$http', function(http) {
        var QuizService = function(){
            order: []
        };

        QuizService.prototype.first = function(){
            http({method: 'GET', url: QuizConfig.baseUrl + '/first'}).
                success(function(data, status, headers, config) {
                    console.log(data);
                }).
                error(function(data, status, headers, config) {
                    console.log(data);
                    console.log('error');
                });
        };


        QuizService.prototype.next = function(){
        };


        QuizService.prototype.prev = function(){
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

        QuizService.prototype.order = function(){
            http({method: 'GET', url: QuizConfig.baseUrl + '/order'}).
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
        quizService.order();
        $scope.question = quizService.first();
    };

    $scope.next = function() {
        $scope.question = quizService.next();
    };

    $scope.prev = function() {
        $scope.question = quizService.prev();
    };



    $scope.question = {name:'learn angular', text:'learn angular', form: 'http://localhost/rendeslms/assets/templates/variantquestion.html', variants:[{text:'var1'}, {text:'var2'}]};

    $scope.answerForm = function(){
        var questionType = $scope.question.type;
        var questionHandler = new window[questionType]();
        return questionHandler.renderAnswerForm($scope.question);
    }
}

QuizQuestionCtrl.$inject = ['$scope','quizService'];
