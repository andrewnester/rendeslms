<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Modules\Courses\Repositories\ResultRepositories\XAPI;
use \Rendes\Modules\Courses\Interfaces\ResultRepositories as ResultRepositories;

class DocumentResultRepository extends BaseResultRepository
{
    public function markComplete(\Rendes\Modules\Courses\Entities\Lecture\Document $document, \Rendes\Modules\User\Entities\Student $student)
	{
		$lecture = $document->getLecture();
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
				'id' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$course->getId().'/steps/'.$step->getId().'/lectures/'.$lecture->getId().'/documents/'.$document->getId()),
				'objectType' => 'Activity',
				'definition' => array(
					'name' => array(
						'en-US' => $document->getName()
					),
					'description' => array(
						'en-US' => $document->getDescription())
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

	public function getCountViewed(\Rendes\Modules\Courses\Entities\Lecture\Document $document, \Rendes\Modules\User\Entities\Student $student)
	{
		$lecture = $document->getLecture();
		$step = $lecture->getStep();
		$course = $step->getCourse();

		$searchOptions = array(
			'agent' => json_encode(array(
				'mbox' => $student->getEmail()
			)),
			'verb' => 'http://adlnet.gov/expapi/verbs/viewed',
			'activity' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$course->getId().'/steps/'.$step->getId().'/lectures/'.$lecture->getId()),
			'related_activities' => true,
		);
		return count($this->getXAPI()->getStatements($searchOptions));
	}

}