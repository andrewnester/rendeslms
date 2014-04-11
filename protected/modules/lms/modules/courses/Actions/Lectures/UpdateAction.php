<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Modules\Courses\Actions\Lectures;

class UpdateAction extends \Rendes\Actions\LMSAction
{
	public $entityName = '';
	public $serviceName = '';

	public function run($id, $lectureID, $stepID, $courseID)
	{
		try{
			$course = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Lecture\Lecture')->getByID($lectureID);
			$item = $this->getEntityManager()->getRepository($this->entityName)->getByID($id);
		}catch(\Exception $e){
			throw new \CHttpException(404, 'There is no such lecture item');
		}

		$itemData = $this->getHttpClient()->get(str_replace('\\', '_', trim($this->entityName, '\\')));
		$item->setAttributes($itemData);

		$itemService = new $this->serviceName();

		if(!is_null($itemData) && $item->validate())
		{
			$item = $itemService->populate($item, $course, $itemData);

			$this->getEntityManager()->persist($item);
			$this->getEntityManager()->flush();

			$this->controller->redirect(array('/lms/courses/default/view','id' => $courseID));
		}

		$this->controller->render('update',array(
			'model'=>$item,
			'course' => $course,
		));
	}
}