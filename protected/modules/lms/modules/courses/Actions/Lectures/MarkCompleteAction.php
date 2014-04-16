<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Modules\Courses\Actions\Lectures;

class MarkCompleteAction extends \Rendes\Actions\LMSAction
{
	public $entityName = '';
	public $serviceName = '';

	public function run($id, $lectureID, $stepID, $courseID)
	{
		try{
			$item = $this->getEntityManager()->getRepository($this->entityName)->getByID($id);
		}
		catch(\Exception $e){
			$this->getHttpClient()->json('not found', 404);
		}

		$user = $this->getUser()->getEntity();
		if($user->getRole() != 'student'){
			$this->getHttpClient()->json('ok');
		}

		$itemService = new $this->serviceName();
		$itemService->getResultRepository()->markComplete($item, $user);
		$this->getHttpClient()->json('ok');
	}
}