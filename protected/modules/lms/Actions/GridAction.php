<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Actions;

class GridAction extends LMSAction
{
	public $entityName = '';

	public function run()
	{
		$dataProvider = $this->getEntityManager()->getRepository($this->entityName);
		$requestService = new \Rendes\Modules\Courses\Services\RequestService();

		$criteria = $requestService->prepareLimit(new \CDbCriteria());
		$dataProvider->setCriteria($criteria);
		$dataProvider->setPagination(array(
			'pageSize' => $requestService->getLimit()
		));

		$this->controller->render('index',array(
			'dataProvider'=>$dataProvider,
			'domain' => new $this->entityName()
		));
	}
}