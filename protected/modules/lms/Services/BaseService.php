<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Services;

abstract class BaseService
{
    private $entityManager;

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
     * @return \SwiftMailer
     */
    public function getMailer()
    {
        return \Yii::app()->mail;
    }


    public function getClassName($classname)
    {
        if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
            $classname = $matches[1];
        }
        return $classname;
    }

    /**
     * @return \Rendes\Components\XAPIComponent
     */
    public function getXAPI()
    {
        return \Yii::app()->getModule('lms')->xapi;
    }

	/**
	 * @param $name
	 * @return mixed
	 */
	public function getService($name)
	{
		return \Yii::app()->getModule('lms')->$name;
	}

	protected function loadResultRepository($name)
	{
		$repositoryName = \Yii::app()->getModule('lms')->params->resultRepositories[$name];
		return new $repositoryName();
	}
}