<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Actions;

class UnassignAction extends LMSAction
{
	public $entityName = '';
	public $serviceName = '';
	public $itemEntityName='';
	public $returnURL = '/lms/courses/default/view';

	public function run($id, $itemID)
	{
		try{
			$sourceItem = $this->getEntityManager()->getRepository($this->itemEntityName)->getByID($itemID);
			$itemToUnassign = $this->getEntityManager()->getRepository($this->entityName)->getByID($id);
		}catch(\Exception $e){
			throw new \CHttpException(404, 'Such item does not exist');
		}

		$itemService = new $this->serviceName();
		$itemToUnassign = $itemService->unassign($itemToUnassign, $sourceItem);
		$this->getEntityManager()->flush();

		$this->controller->redirect(array($this->returnURL,'id' => $itemID));
	}
}