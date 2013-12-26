<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 18.11.13
 * Time: 16:40
 * To change this template use File | Settings | File Templates.
 */

class LMSController extends Controller
{
    private $entityManager = null;


    public function actionError()
    {
        if($error=Yii::app()->getModule('lms')->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest){
                echo $error['message'];
            }
            else{
                $this->render('error', $error);
            }
        }
    }


    /**
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if(is_null($this->entityManager)){
            $this->entityManager = Yii::app()->controller->module->doctrine->getEntityManager();
        }
        return $this->entityManager;
    }

    /**
     * @return RequestComponent
     */
    public function getRequest()
    {
        return Yii::app()->getModule('lms')->request;
    }

    /**
     * @return LMSUser
     */
    public function getUser()
    {
        return Yii::app()->getModule('lms')->getModule('user')->user;
    }



    /**
     * @param string $operation
     * @return bool
     */
    public function checkAccess($operation)
    {
        return Yii::app()->getModule('lms')->getModule('user')->authManager->checkAccess($operation, $this->getUser()->id);
    }

    public function filterLMSAccessControl($filterChain)
    {
        $filter=new LMSAccessControlFilter;
        $filter->setRules($this->accessRules());
        $filter->filter($filterChain);
    }
}