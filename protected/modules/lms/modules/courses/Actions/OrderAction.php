<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Modules\Courses\Actions;

class OrderAction extends \Rendes\Actions\LMSAction
{
	public $entityName = '';
	public $serviceName = '';

	public function run()
	{
		$orderData = $this->getHttpClient()->get('order');
		$service = new $this->serviceName();
		$iterator = $this->getEntityManager()->getRepository($this->entityName)->getByIDArray(array_values($orderData));
		foreach($iterator as $element){
			$element->setOrder($service->countOrder($orderData, $element->getId()));
		}

		$this->getEntityManager()->flush();
		$this->getEntityManager()->clear();

		$this->getHttpClient()->json(array('message' => 'Successfully Saved'));
	}
}