<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Actions;

class SearchAction extends LMSAction
{
	public $entityName = '';

	public function run()
	{
		$isAdmin = $this->controller->checkAccess('administrator');

		$requestService = new \Rendes\Modules\Courses\Services\RequestService();
		$criteria = $requestService->prepareSearchCriteria($this->getHttpClient(), $isAdmin);
		$criteria = $requestService->prepareLimit($criteria);


		$dataProvider = $this->getEntityManager()->getRepository($this->entityName);
		$dataProvider->setCriteria($criteria);
		$dataProvider->setPagination(array(
			'pageSize' => $requestService->getLimit()
		));

		$domain = new $this->entityName();
		$domain->setAttributes($requestService->getData('Grid'), false);

		$this->controller->renderPartial('_grid',array(
			'dataProvider'=>$dataProvider,
			'filter' => $domain
		));
	}
}