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
            $this->repository = $this->loadResultRepository('lectures');
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


}