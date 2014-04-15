<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Interfaces as Interfaces;
use \Rendes\Modules\Courses\Interfaces\Services\ILearningActivityService;
use \Rendes\Modules\User\Entities\User;

class CourseService extends CourseBaseService
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
            $this->repository = $this->loadResultRepository('courses');
        }
        return $this->repository;
    }

    public function populate(\Rendes\Modules\Courses\Entities\Course $course, $courseData)
    {
        $course->setName($courseData['name']);
        $course->setDescription($courseData['description']);
		$course->setIsPublic($courseData['isPublic']);
        return $course;
    }

	public function assign(\Rendes\Modules\Courses\Entities\Course $course, \Rendes\Modules\Groups\Entities\Group $group)
	{
		$course->getGroups()->add($group);
		$group->getCourses()->add($course);
		return $course;
	}

	public function unassign(\Rendes\Modules\Courses\Entities\Course $course, \Rendes\Modules\Groups\Entities\Group $group)
	{
		$group->getCourses()->removeElement($course);
		$course->getGroups()->removeElement($group);
		return $course;
	}

}