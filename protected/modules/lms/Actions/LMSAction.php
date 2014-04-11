<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Actions;

abstract class LMSAction extends \CAction
{

	private $entityManager = null;

	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
	{
		if(is_null($this->entityManager)){
			$this->entityManager = \Yii::app()->controller->module->doctrine->getEntityManager();
		}
		return $this->entityManager;
	}

	/**
	 * @return \Rendes\Components\HttpClientComponent
	 */
	public function getHttpClient()
	{
		return \Yii::app()->getModule('lms')->http;
	}

	/**
	 * @return \Rendes\Modules\User\Components\WebUser
	 */
	public function getUser()
	{
		return \Yii::app()->getModule('lms')->getModule('user')->user;
	}

	/**
	 * @return \Rendes\Components\XAPIComponent
	 */
	public function getXAPI()
	{
		return \Yii::app()->getModule('lms')->xapi;
	}
}