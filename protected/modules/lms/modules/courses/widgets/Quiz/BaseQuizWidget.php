<?php
/**
 * User: nester_a
 * Date: 03.02.14
 */

namespace Rendes\Modules\Courses\Widgets\Quiz;

abstract class BaseQuizWidget extends \CWidget implements \Rendes\Modules\Courses\Interfaces\Quiz\IQuizWidget
{
    public $quiz;
    public $options;

    public function init()
    {
        $this->registerClientScript();
    }

    public function run()
    {
        $this->render($this->quiz);
    }

    private function registerClientScript()
    {
        $baseUrl = \Yii::app()->baseUrl;
        $cs = \Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl.'/assets/js/angular.min.js');
        $cs->registerScriptFile($baseUrl.'/assets/js/quiz/quiz.js');
    }
}