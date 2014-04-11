<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Interfaces as Interfaces;
use \Rendes\Modules\Courses\Interfaces\Services\ILearningActivityService;
use \Rendes\Modules\User\Entities\User;

class LectureService extends CourseBaseService implements ILearningActivityService
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
        $lecture->setStep($step);
        return $lecture;
    }

	public function isAvailableToStart($activityObject, User $user)
	{
		// TODO: Implement isAvailableToStart() method.
	}

	public function isPassed($activityObject, User $user)
	{
		// TODO: Implement isPassed() method.
	}

	public function currentProgress($activityObject, User $user)
	{
		// TODO: Implement currentProgress() method.
	}


}