<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Actions;

class AssignAction extends LMSAction
{
	public $entityName = '';
	public $serviceName = '';
	public $itemEntityName='';
	public $returnURL = '/lms/courses/default/view';

	public function run($itemID)
	{
		try{
			$item = $this->getEntityManager()->getRepository($this->itemEntityName)->getByID($itemID);
		}catch(\Exception $e){
			throw new \CHttpException(404, 'Such course does not exist');
		}

		$service = new $this->serviceName();

		$data = $this->getHttpClient()->get('List', null);
		if(!is_null($data)){
			try{
				$itemToAssign = $this->getEntityManager()->getRepository($this->entityName)->getByID($data['id']);
			}catch(\Exception $e){
				throw new \CHttpException(404, 'Such item does not exist');
			}

			$itemToAssign = $service->assign($itemToAssign, $item);

			try{
				$this->getEntityManager()->flush();
			}catch(\Doctrine\DBAL\DBALException $e){
				$this->controller->redirect(array($this->returnURL,'id' => $itemID));
			}

			$this->controller->redirect(array($this->returnURL,'id' => $itemID));
		}

		$dataProvider = $this->getEntityManager()->getRepository($this->entityName);
		$requestService = new \Rendes\Modules\Courses\Services\RequestService();

		$criteria = $requestService->prepareLimit(new \CDbCriteria());
		$dataProvider->setCriteria($criteria);
		$dataProvider->setPagination(array(
			'pageSize' => $requestService->getLimit()
		));

		$this->controller->render('assign', array(
			'item' => $item,
			'dataProvider' => $dataProvider,
			'filter' => new $this->entityName(),
		));
	}
}