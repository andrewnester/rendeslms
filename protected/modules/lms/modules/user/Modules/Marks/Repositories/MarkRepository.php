<?php

namespace Rendes\Modules\User\Modules\Marks\Repositories;

use Doctrine\ORM\EntityRepository;

class MarkRepository extends EntityRepository
{
    protected $_id = '\Rendes\Modules\User\Modules\Marks\Entities\Mark';

	public function getMark(\Rendes\Modules\Courses\Entities\Step $step, \Rendes\Modules\User\Entities\Student $student)
	{
		$query = $this->getEntityManager()
						->createQuery('SELECT c.mark FROM ' . $this->getEntityName() . ' c
                                        WHERE c.student=:student AND c.step=:step');
		$query->setParameter('student', $student);
		$query->setParameter('step', $step);

		try{
			$mark = $query->getSingleScalarResult();
		}catch(\Doctrine\ORM\NoResultException $e){
			$mark = 0;
		}

		return $mark;
	}

	public function getMarkObject(\Rendes\Modules\Courses\Entities\Step $step, \Rendes\Modules\User\Entities\Student $student)
	{
		$query = $this->getEntityManager()
					  ->createQuery('SELECT c FROM ' . $this->getEntityName() . ' c
                                        WHERE c.student=:student AND c.step=:step');
		$query->setParameter('student', $student);
		$query->setParameter('step', $step);

		try{
			$mark = $query->getSingleResult();
		}catch(\Doctrine\ORM\NoResultException $e){
			$mark = null;
		}

		return $mark;
	}

	public function getCourseMarks(\Rendes\Modules\Courses\Entities\Course $course, \Rendes\Modules\Groups\Entities\Group $group)
	{
		$steps = $course->getSteps();
		$students = $group->getStudents();

		$studentIDs = array();
		foreach($students as $student){
			$studentIDs[] = $student->getId();
		}

		$stepIDs = array();
		foreach($steps as $step){
			$stepIDs[] = $step->getId();
		}

		$query = $this->getEntityManager()
					  ->createQuery('SELECT c.mark, st.id as student_id, s.id as step_id FROM ' . $this->getEntityName() . ' c
					  					JOIN c.student st
					  					JOIN c.step s
                                        WHERE c.student IN (:students) AND c.step IN (:steps)');
		$query->setParameter('students', $studentIDs);
		$query->setParameter('steps', $stepIDs);
		$rows = $query->getArrayResult();

		$marks = array();

		foreach($rows as $row){
			if(!isset($marks[$row['student_id']])){
				$marks[$row['student_id']] = array();
			}
			$marks[$row['student_id']][$row['step_id']] = $row['mark'];
		}

		foreach($students as $student){
			$studentID = $student->getId();
			if(!isset($marks[$studentID])){
				$marks[$studentID] = array();
			}
			foreach($steps as $step){
				$stepID = $step->getId();
				if(!isset($marks[$studentID][$stepID])){
					$marks[$studentID][$stepID] = 0;
				}
			}
		}


		return $marks;
	}

}