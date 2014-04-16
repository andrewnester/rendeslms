<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Modules\Courses\Repositories\ResultRepositories\XAPI;
use \Rendes\Modules\Courses\Interfaces\ResultRepositories as ResultRepositories;

class VideoResultRepository extends BaseResultRepository
{
    public function markComplete(\Rendes\Modules\Courses\Entities\Lecture\Video $video, \Rendes\Modules\User\Entities\Student $student)
	{
		$lecture = $video->getLecture();
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
				'id' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$course->getId().'/steps/'.$step->getId().'/lectures/'.$lecture->getId().'/videos/'.$video->getId()),
				'objectType' => 'Activity',
				'definition' => array(
					'name' => array(
						'en-US' => $video->getName()
					),
					'description' => array(
						'en-US' => $video->getDescription())
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

	public function getCountViewed(\Rendes\Modules\Courses\Entities\Lecture\Video $video, \Rendes\Modules\User\Entities\Student $student)
	{
		$lecture = $video->getLecture();
		$step = $lecture->getStep();
		$course = $step->getCourse();

		$searchOptions = array(
			'agent' => json_encode(array(
				'mbox' => $student->getEmail()
			)),
			'verb' => 'http://adlnet.gov/expapi/verbs/viewed',
			'activity' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$course->getId().'/steps/'.$step->getId().'/lectures/'.$lecture->getId().'/videos/'.$video->getId()),
			'related_activities' => true,
		);
		return count($this->getXAPI()->getStatements($searchOptions));
	}

}