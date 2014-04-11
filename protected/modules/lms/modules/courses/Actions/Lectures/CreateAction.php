<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Modules\Courses\Actions\Lectures;

class CreateAction extends \Rendes\Actions\LMSAction
{
	public $entityName = '';
	public $serviceName = '';

	public function run($lectureID, $stepID, $courseID)
	{
		$item = new $this->entityName();
		try{
			$lecture = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Lecture\Lecture')->getByID($lectureID);
		}catch(\Exception $e){
			throw new \CHttpException(404, 'Such lecture does not exist');
		}

		$itemData = $this->getHttpClient()->get(str_replace('\\', '_', trim($this->entityName, '\\')));
		$item->setAttributes($itemData, false);
		$item->setScenario('create');

		$itemService = new $this->serviceName();

		if(!is_null($itemData) && $item->validate())
		{
			$item = $itemService->populate($item, $lecture, $itemData);

			$this->getEntityManager()->persist($item);
			$this->getEntityManager()->flush();

			$this->controller->redirect(array('/lms/courses/lectures/view','id' => $lectureID, 'stepID' => $stepID, 'courseID' => $courseID));
		}


		$this->controller->render('create',array(
			'model' => $item,
			'lecture' => $lecture,
		));
	}
}