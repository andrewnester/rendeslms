<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;

class StepService
{
    /**
     * @param \Doctrine\ORM\EntityManager $em
     * @param int $courseID
     * @return array
     */
    public function getCourseStepsList(\Doctrine\ORM\EntityManager $em, $courseID)
   {
       $steps = $em->getRepository('\Rendes\Modules\Courses\Entities\Step')->getByCourseID($courseID);
       $stepsList = array();

       foreach($steps as $step){
           $stepsList[$step['id']] = $step['name'];
       }

       return $stepsList;
   }
}