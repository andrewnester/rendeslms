<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Modules\Courses\Actions\CourseItems;

class CreateAction extends \Rendes\Actions\LMSAction
{
	public $entityName = '';
	public $serviceName = '';

	public function run($courseID)
	{
		$item = new $this->entityName();
		try{
			$course = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Course')->getByID($courseID);
		}catch(\Exception $e){
			throw new \CHttpException(404, 'Such course does not exist');
		}

		$itemData = $this->getHttpClient()->get(str_replace('\\', '_', trim($this->entityName, '\\')));
		$item->setAttributes($itemData);
		$item->setScenario('create');

		$stepsService = new $this->serviceName();

		if(!is_null($itemData) && $item->validate())
		{
			$item = $stepsService->populate($item, $course, $itemData);

			$this->getEntityManager()->persist($item);
			$this->getEntityManager()->flush();

			$this->controller->redirect(array('/lms/courses/default/view','id' => $courseID));
		}

		$this->controller->render('create',array(
			'model' => $item,
			'course' => $course
		));
	}
}