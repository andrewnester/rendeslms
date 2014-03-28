<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 18.11.13
 * Time: 16:40
 * To change this template use File | Settings | File Templates.
 */

namespace Rendes\Controllers;

class LMSController extends \Controller
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

	public function safeClassLoad($className)
	{
		try{
			\Yii::import($className, true);
			$class = new \ReflectionClass($className);
		}catch(\Exception $e){
			throw new \CHttpException($e->getMessage());
		}
		return $class->newInstance();
	}

    /**
     * @param string $operation
     * @return bool
     */
    public function checkAccess($operation)
    {
        return \Yii::app()->getModule('lms')->getModule('user')->authManager->checkAccess($operation, $this->getUser()->id);
    }

    public function filterLMSAccessControl($filterChain)
    {
        $filter=new \Rendes\Filters\LMSAccessControlFilter;
        $filter->setRules($this->accessRules());
        $filter->filter($filterChain);
    }
}