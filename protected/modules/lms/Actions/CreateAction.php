<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Actions;

class CreateAction extends LMSAction
{
	public $entityName = '';
	public $serviceName = '';

	public function run()
	{
		$item = new $this->entityName();

		$itemData = $this->getHttpClient()->get(str_replace('\\', '_', trim($this->entityName, '\\')));
		$item->setAttributes($itemData, false);
		$item->setScenario('create');

		$itemService = new $this->serviceName();

		if(!is_null($itemData) && $item->validate())
		{
			$item = $itemService->populate($item, $itemData);

			$this->getEntityManager()->persist($item);
			$this->getEntityManager()->flush();

			$this->controller->redirect(array('view','id'=>$item->getId()));
		}


		$this->controller->render('create',array(
			'model' => $item,
		));
	}
}