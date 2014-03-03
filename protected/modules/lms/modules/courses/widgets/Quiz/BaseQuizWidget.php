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
    public $assetUrl;

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
        $this->assetUrl = \Yii::app()->getAssetManager()->publish(\Yii::getPathOfAlias('application.modules.lms.assets'));
        \Yii::app()->clientScript->registerScriptFile($this->assetUrl.'/js/angular.min.js');
        \Yii::app()->clientScript->registerScriptFile($this->assetUrl.'/js/quiz/quiz.js');
    }
}