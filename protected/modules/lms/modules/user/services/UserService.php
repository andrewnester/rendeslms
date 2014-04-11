<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\User\Services;

use Rendes\Services\BaseService;

class UserService extends BaseService
{
    public function getTeachersList(\Doctrine\ORM\EntityManager $em)
    {
        $teachers = $em->getRepository('\Rendes\Modules\User\Entities\User')
                       ->getTeachers();

        $teachersList = array(
            "" => ""
        );
        foreach($teachers as $teacher){
            $teachersList[$teacher['id']] = $teacher['name'];
        }

        return $teachersList;
    }


    public function populate(\Rendes\Modules\User\Entities\User $user, $userData)
    {
        $user->setName($userData['name']);
        $user->setPassword($userData['password']);
        $user->setEmail($userData['email']);
        $user->setActivated(false);
        $user->setActivateCode($this->generateActivationCode($user));
        return $user;
    }


	public function populateStudent(\Rendes\Modules\User\Entities\Student $student, $studentData)
	{
		$student->setFio($studentData['fio']);
		$student->setAge($studentData['age']);
		$student->setPlace($studentData['place']);
		$student->setStudentNumber($studentData['studentNumber']);

		$student = $this->populate($student, $studentData);
		return $student;
	}

    /**
     * @param \Rendes\Modules\User\Entities\User $user
     * @return string
     */
    public function generateActivationCode(\Rendes\Modules\User\Entities\User $user)
    {
        return md5(sha1($user->getName() . time()));
    }

    /**
     * @param \Rendes\Modules\User\Entities\User $user
     * @param string $linkToActivate
     * @return mixed
     */
    public function sendActivationLink(\Rendes\Modules\User\Entities\User $user, $linkToActivate)
    {
        $mailer = $this->getMailer();
        $linkToActivate .= '?code=' . $user->getActivateCode();

        $message = 'Here is your activation link';
        $message .= '<a href="'.$linkToActivate.'">'.$linkToActivate.'</a>';

        return $mailer->sendFromAdmin($user->getEmail(), \Yii::app()->name . ' - Activation Code', $message);
    }

    /**
     * @param \Rendes\Modules\User\Entities\User $user
     * @return bool
     */
    public function registerInLRS(\Rendes\Modules\User\Entities\User $user)
    {
        $xapi = $this->getXAPI();
        return $xapi->registerUser($user);
    }
}