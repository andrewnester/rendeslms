<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Entities\Quiz as Quiz;
use \Rendes\Modules\Courses\Entities\Quiz\Questions as Questions;

class QuestionService extends \Rendes\Services\BaseService
{

    public function populateQuestion(Questions\Question $question, $questionData)
    {
        $question->setTitle($questionData['title']);
        $question->setQuestion($questionData['question']);
        $question->setWeight($questionData['weight']);
        $question->setAnswers($questionData['answers']);

        return $question;
    }

    public function populateVariantQuestion(Questions\VariantQuestion $question, $questionData)
    {
        $question = $this->populateQuestion($question, $questionData);
        $question->setVariants($questionData['variants']);

        return $question;
    }

    public function getWidgetByClassName($classname)
    {
        $widgetPath = \Yii::app()->getModule('lms')->params->namespaces['questions']['widgets'];
        $widgetClass = $widgetPath . '\\' . $this->getClassName($classname);
        return new $widgetClass();
    }



    public function getAvailableTypes()
    {
        return array(
            'Question' => 'Simple Question',
            'VariantQuestion' => 'Question with variants'
        );
    }
}