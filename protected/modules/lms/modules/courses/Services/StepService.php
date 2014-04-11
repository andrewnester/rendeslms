<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;

class StepService extends CourseBaseService
{

    /**
     * @param \Doctrine\ORM\EntityManager $em
     * @param int $courseID
     * @return array
     */
    public function getCourseStepsList($courseID)
   {
       $steps = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Step')->getByCourseID($courseID);
       $stepsList = array();

       foreach($steps as $step){
           $stepsList[$step['id']] = $step['name'];
       }

       return $stepsList;
   }

    public  function populate(\Rendes\Modules\Courses\Entities\Step $step, \Rendes\Modules\Courses\Entities\Course $course, $stepData)
    {
        $step->setName($stepData['name']);
        $step->setDescription($stepData['description']);
        $step->setCourse($course);

        return $step;
    }

	public function getResultRepository()
	{
		// TODO: Implement getResultRepository() method.
	}


}