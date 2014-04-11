<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\User\Services;

class TeacherService extends \Rendes\Services\BaseService
{

    public function assign(\Rendes\Modules\User\Entities\Teacher $teacher, \Rendes\Modules\Courses\Entities\Course $course)
    {
        $teacher->getCourses()->add($course);
		$course->getTeachers()->add($teacher);
        return $teacher;
    }

	public function unassign(\Rendes\Modules\User\Entities\Teacher $teacher, \Rendes\Modules\Courses\Entities\Course $course)
	{
		$teacher->getCourses()->removeElement($course);
		$course->getTeachers()->removeElement($teacher);
		return $teacher;
	}

	public function getTeachersList()
	{
		$teachers = $this->getEntityManager()->getRepository('\Rendes\Modules\User\Entities\Teacher')->getTeachers();
		$teachersList = array();

		foreach($teachers as $step){
			$teachersList[$step['id']] = $step['name'];
		}

		return $teachersList;
	}

	public function populate(\Rendes\Modules\User\Entities\Teacher $teacher, $teacherData)
	{
		$teacher->setName($teacherData['name']);
		$teacher->setEmail($teacherData['email']);
		$teacher->setPassword($teacherData['password']);
		$teacher->setDegree($teacherData['degree']);
		$teacher->setActivated(true);
		$teacher->setActivateCode('');

		return $teacher;
	}

	public function getResultRepository()
	{
		// TODO: Implement getResultRepository() method.
	}


}