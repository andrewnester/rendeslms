<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Interfaces as Interfaces;

class LectureService extends CourseBaseService
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
            $this->repository = $this->loadResultRepository('lectures');
        }
        return $this->repository;
    }

    public function populate(\Rendes\Modules\Courses\Entities\Lecture\Lecture $lecture, \Rendes\Modules\Courses\Entities\Step $step, $lectureData)
    {
        $lecture->setName($lectureData['name']);
        $lecture->setDescription($lectureData['description']);

        $rules = array();
        foreach($lectureData['rules_id'] as $ruleID){
            if(!empty($ruleID)){
                $rules[$ruleID] = isset($lectureData['rules'][$ruleID]) ? $lectureData['rules'][$ruleID] : array();
            }
        }

        $lecture->setPassingRules($rules);
        $lecture->setStep($step);
        return $lecture;
    }

    public function getAvailableRules()
    {
        $rules = array();
        $pathToRulesDir = __DIR__ . '/../Entities/Lecture/Rules/';
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
     * @param \Rendes\Modules\Courses\Entities\Lecture\Lecture $lecture
     * @return bool
     */
    public function isPassed(\Rendes\Modules\Courses\Entities\Lecture\Lecture $lecture)
    {
        $rules = $this->getRulesChain($lecture);
        foreach($rules as $rule){
            if(!$rule['class']->validate($this->getResultRepository(), $rule['options'])){
                return false;
            }
        }

        return true;
    }


    /**
     * @param array $orderArray
     * @param int $lectureID
     * @return int
     */
    public function countOrder($orderArray, $lectureID)
    {
        $orderCount = count($orderArray);
        for($i=0; $i<$orderCount; $i++){
            if($lectureID == $orderArray[$i]){
                return $i+1;
            }
        }

        return 0;
    }


    private function getRulesChain(\Rendes\Modules\Courses\Entities\Lecture\Lecture $lecture)
    {
        $rules = array();
        $passingRules = $lecture->getPassingRules();
        $availableRules = $this->getAvailableRules();
        foreach($passingRules as $ruleID => $options){
            $rules[] = array(
                'class' => new $availableRules[$ruleID]['classname'],
                'options' => $options
            );
        }

        if(empty($rules)){
            $rules[] = array(
                'class' => new \Rendes\Modules\Courses\Entities\Lecture\Rules\ViewedLectureRule(),
                'options' => array()
            );
        }

        return $rules;
    }

}