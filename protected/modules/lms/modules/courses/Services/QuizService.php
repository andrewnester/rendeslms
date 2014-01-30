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
        $quiz->setStep($step);
        return $quiz;
    }

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

}