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

}