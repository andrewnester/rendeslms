<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\User\Services;

class UserService
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
}