<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Interfaces as Interfaces;

class QuizService extends \Rendes\Services\BaseService
{

    /**
     * @var Interfaces\ResultRepositories\ILectureResultRepository
     */
    private $repository = null;

    /**
     * @return Interfaces\ResultRepositories\ILectureResultRepository
     */
    public function getResultRepository()
    {
        if(is_null($this->repository)){
            $this->repository = $this->loadResultRepository('quiz');
        }
        return $this->repository;
    }

    public function populate(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\Courses\Entities\Step $step, $quizData)
    {
        $quiz->setName($quizData['name']);
        $quiz->setDescription($quizData['description']);

        $rules = $this->getAvailableRules();
        $rule = array();
        $ruleID = isset($quizData['rule_id']) ? $quizData['rule_id'] : null;
        if(!is_null($ruleID)){
            $rule[$ruleID]['classname'] = $rules[$ruleID]['classname'];
            $rule[$ruleID]['options'] = isset($quizData['rule'][$ruleID]) ? $quizData['rule'][$ruleID] : array();
            $quiz->setPassingRule($rule);
        }

        $widgets = $this->getAvailableWidgets();
        $widget = array();
        $widgetID = isset($quizData['widget_id']) ? $quizData['widget_id'] : null ;
        if(!empty($widgetID)){
            $widget[$widgetID]['classname'] = $widgets[$widgetID]['classname'];
            $widget[$widgetID]['options'] = isset($quizData['widget'][$widgetID]) ? $quizData['widget'][$widgetID] : array();
            $quiz->setWidget($widget);
        }

        $quiz->setStep($step);
        return $quiz;
    }

    /**
     * @return array
     */
    public function getAvailableRules()
    {
        $rules = array();
        $pathToRulesDir = __DIR__ . '/../Entities/Quiz/Rules/';
        $dir = opendir($pathToRulesDir);
        while (false !== ($entry = readdir($dir))) {
            if(strpos($entry, '.json') !== false){
                $configContent = file_get_contents($pathToRulesDir . $entry);
                $decoded = json_decode($configContent, true);
                $rules[$decoded['id']] = $decoded;
            }
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function getAvailableWidgets()
    {
        $widgets = array();
        $pathToWidgetsDir = __DIR__ . '/../Widgets/Quiz/';
        $dir = opendir($pathToWidgetsDir);
        while (false !== ($entry = readdir($dir))) {
            if(strpos($entry, '.json') !== false){
                $configContent = file_get_contents($pathToWidgetsDir . $entry);
                $decoded = json_decode($configContent, true);
                $widgets[$decoded['id']] = $decoded;
            }
        }

        return $widgets;
    }

    /**
     * @param \Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz
     * @return mixed
     */
    public function getQuizWidget(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz)
    {
        $widget = array_shift(array_values($quiz->getWidget()));

        $properties = array(
            'quiz' => $quiz,
            'options' => $widget['options']
        );
        return \Yii::app()->getWidgetFactory()->createWidget($this, $widget['classname'], $properties);
    }

    /**
     * @param \Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz
     * @return mixed
     */
    public function getQuizOptions(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz)
    {
        $widget = array_shift(array_values($quiz->getWidget()));
        return $widget['options'];
    }

    /**
     * @param \Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz
     * @return array
     */
    public function getQuestionsOrder(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz)
    {
        $question = $quiz->getQuestions();
        $quizOptions = $this->getQuizOptions($quiz);

        $order = array();
        foreach($question as $question){
            $order[] = $question->getId();
        }

        if(isset($quizOptions['random']) && $quizOptions['random']){
            shuffle($order);
        }

        return $order;
    }

    /**
     * @param \Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz
     * @param \Rendes\Modules\User\Entities\User $user
     * @return bool|mixed
     */
    public function getQuizResults(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user)
    {
        $xapi = $this->getXAPI();
        $searchOptions = array(
            'agent' => json_encode(array(
                'mbox' => $user->getEmail()
            )),
            'activity' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$quiz->getStep()->getCourse()->getId().'/steps/'.$quiz->getStep()->getId().'/quizzes/'.$quiz->getId()),
            'related_activities' => true
        );
        return $xapi->getStatements($searchOptions);
    }
}