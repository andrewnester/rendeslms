<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Modules\Courses\Repositories\ResultRepositories\XAPI;
use \Rendes\Modules\Courses\Interfaces\ResultRepositories as ResultRepositories;

class SlideResultRepository extends BaseResultRepository
{
    public function markComplete(\Rendes\Modules\Courses\Entities\Lecture\Slide $Slide, \Rendes\Modules\User\Entities\Student $student)
	{
		$lecture = $Slide->getLecture();
		$step = $lecture->getStep();
		$course = $step->getCourse();

		$statement = array(
			'actor' => array(
				'mbox' => $student->getEmail()
			),
			'verb' => array(
				'id' => 'http://adlnet.gov/expapi/verbs/viewed'
			),
			'object' => array(
				'id' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$course->getId().'/steps/'.$step->getId().'/lectures/'.$lecture->getId().'/slides/'.$Slide->getId()),
				'objectType' => 'Activity',
				'definition' => array(
					'name' => array(
						'en-US' => $Slide->getName()
					),
					'description' => array(
						'en-US' => $Slide->getDescription())
				)
			),
			'context' => array(
				'contextActivities' => array(
					'grouping' => array(
						'id' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$course->getId().'/steps/'.$step->getId().'/lectures/'.$lecture->getId()),
					)
				)
			)
		);

		$xapi = $this->getXAPI();
		return $xapi->postStatement($statement);
	}

	public function getCountViewed(\Rendes\Modules\Courses\Entities\Lecture\Slide $slide, \Rendes\Modules\User\Entities\Student $student)
	{
		$lecture = $slide->getLecture();
		$step = $lecture->getStep();
		$course = $step->getCourse();

		$searchOptions = array(
			'agent' => json_encode(array(
				'mbox' => $student->getEmail()
			)),
			'verb' => 'http://adlnet.gov/expapi/verbs/viewed',
			'activity' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$course->getId().'/steps/'.$step->getId().'/lectures/'.$lecture->getId().'/slides/'.$slide->getId()),
			'related_activities' => true,
		);
		$statements = $this->getXAPI()->getStatements($searchOptions);
		return count($statements);
	}

}