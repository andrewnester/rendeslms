<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\User\Services;

class StudentService extends UserBaseService
{
	private $repository = null;

    public function assign(\Rendes\Modules\User\Entities\Student $student, \Rendes\Modules\Groups\Entities\Group $group)
    {
        $student->setGroup($group);
		$group->getStudents()->add($student);
        return $student;
    }

	public function unassign(\Rendes\Modules\User\Entities\Student $student, \Rendes\Modules\Groups\Entities\Group $group)
	{
		$group->getStudents()->removeElement($student);
		$student->setGroup(null);
		return $student;
	}


	public function getCourses(\Rendes\Modules\User\Entities\Student $student)
	{
		if(is_null($student->getGroup())){
			throw new \CHttpException(500, 'Student does not belong to any group');
		}

		return $student->getGroup()->getCourses();
	}

	public function getAllProgress(\Rendes\Modules\User\Entities\Student $student)
	{
		$studentProgress = array();
		$courses = $this->getCourses($student);
		$stepService = $this->getService('stepService');
		foreach($courses as $course){
			$steps = $course->getSteps();
			foreach($steps as $step){
				$studentProgress[$step->getId()] = $stepService->currentProgress($step, $student);
			}
		}

		return $studentProgress;
	}

}