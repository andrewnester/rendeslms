<?php
/**
 * User: nester_a
 * Date: 03.02.14
 */

namespace Rendes\Modules\Courses\Widgets\Quiz;

class SimpleQuizWidget extends BaseQuizWidget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $this->renderWidget($this->quiz);
    }

    public function renderWidget(\Rendes\Modules\Courses\Interfaces\Quiz\IQuiz $quiz)
    {
        $step = $quiz->getStep();
        $course = $step->getCourse();
        $questionsUrl = \Yii::app()->createAbsoluteUrl('lms/courses/'.$course->getId().'/steps/'.$step->getId().'/quizzes/'.$quiz->getId().'/questions');
        $templatesUrl = \Yii::app()->request->getBaseUrl(true) . '/assets/templates';
        include_once __DIR__ . '/templates/simple.phtml';
    }

}