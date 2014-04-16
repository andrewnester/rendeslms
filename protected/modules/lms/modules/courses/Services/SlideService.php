<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Entities\Lecture as Lecture;
use Rendes\Modules\Courses\Interfaces\Services\ILearningActivityService;

class SlideService extends CourseBaseService implements ILearningActivityService
{

    public function populate(Lecture\Slide $slide, Lecture\Lecture $lecture, $documentData)
    {
        $slide->setName($documentData['name']);
        $slide->setDescription($documentData['description']);
        $slide->setLecture($lecture);
		$slide->setText($documentData['text']);

        return $slide;
    }

	public function getResultRepository()
	{
		return $this->loadResultRepository('slide');
	}




	public function isAvailableToStart($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return true;
	}

	public function isPassed($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return $this->getResultRepository()->getCountViewed($activityObject, $student) > 0;
	}

	public function isFailed($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return false;
	}

	public function isActive($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return !$this->isPassed($activityObject, $student);
	}

	public function currentProgress($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return $this->isPassed($activityObject, $student) ? 100 : 0;
	}


}