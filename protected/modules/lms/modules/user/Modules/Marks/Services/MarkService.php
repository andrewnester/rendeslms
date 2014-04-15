<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\User\Modules\Marks\Services;
use \Rendes\Services\BaseService;

class MarkService extends BaseService
{
    public function populate(\Rendes\Modules\Groups\Entities\Group $group, $groupData)
    {
        $group->setName($groupData['name']);
        $group->setDescription($groupData['description']);
		$group->setIsPublic($groupData['isPublic']);
        return $group;
    }

	/**
	 * @param \Rendes\Modules\Courses\Entities\Step $step
	 * @param \Rendes\Modules\User\Entities\Student $student
	 * @return mixed
	 */
	public function getMark(\Rendes\Modules\Courses\Entities\Step $step, \Rendes\Modules\User\Entities\Student $student)
	{
		return $this->getEntityManager()->getRepository('\Rendes\Modules\User\Modules\Marks\Entities\Mark')->getMark($step, $student);
	}

	/**
	 * @param \Rendes\Modules\User\Entities\Student $student
	 * @return array
	 */
	public function getStudentMarks(\Rendes\Modules\User\Entities\Student $student)
	{
		$marks = array();
		$courses = $student->getGroup()->getCourses();
		foreach($courses as $course){
			$steps = $course->getSteps();
			foreach($steps as $step){
				$marks[$step->getId()] = $this->getMark($step, $student);
			}
		}
		return $marks;
	}

	public function saveMarks($marksToSave, \Rendes\Modules\User\Entities\Student $student, \Rendes\Modules\User\Entities\Teacher $teacher)
	{
		$marks = array();
		$repository = $this->getEntityManager()->getRepository('\Rendes\Modules\User\Modules\Marks\Entities\Mark');
		$courses = $student->getGroup()->getCourses();
		foreach($courses as $course){
			$steps = $course->getSteps();
			foreach($steps as $step){
				$markObject = $repository->getMarkObject($step, $student);
				if(!is_null($markObject)){
					$marks[$step->getId()] = $repository->getMarkObject($step, $student);
				}
			}
		}

		foreach($marksToSave as $stepID=>$mark){
			if(isset($marks[$stepID])){
				$marks[$stepID]->setMark($mark);
			}else{
				$markToSave = new \Rendes\Modules\User\Modules\Marks\Entities\Mark();
				$markToSave->setStep($this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Step')->getById($stepID));
				$markToSave->setStudent($student);
				$markToSave->setTeacher($teacher);
				$markToSave->setMark($mark);
				$this->getEntityManager()->persist($markToSave);
			}
		}

		$this->getEntityManager()->flush();
	}

}