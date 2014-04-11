<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Actions;

class UpdateAction extends LMSAction
{
	public $entityName = '';
	public $serviceName = '';

	public function run($id)
	{
		$item = $this->getEntityManager()->getRepository($this->entityName)->getById($id);

		$itemService = new $this->serviceName();

		$itemData = $this->getHttpClient()->get(str_replace('\\', '_', trim($this->entityName, '\\')));
		$item->setAttributes($itemData, false);
		$item->setScenario('create');

		if(!is_null($itemData) && $item->validate())
		{
			$item = $itemService->populate($item, $itemData);

			$this->getEntityManager()->flush();
			$this->controller->redirect(array('view','id'=>$item->id));
		}

		$this->controller->render('update',array(
			'model' => $item,
		));
	}
}