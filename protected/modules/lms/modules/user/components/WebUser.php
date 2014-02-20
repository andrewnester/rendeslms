<?php

namespace Rendes\Modules\User\Components;

class WebUser extends \CWebUser
{
    private $model = null;
    private $_access=array();

    public function getRole() {
        if($user = $this->getEntity()){
            return $user->role;
        }
        return false;
    }

    /**
     * @return null|\Rendes\Modules\User\Entities\User
     */
    public function getEntity(){
        if (!$this->isGuest && is_null($this->model)){
            $em = \Yii::app()->controller->module->doctrine->getEntityManager();
            $userRepository = $em->getRepository('Rendes\Modules\User\Entities\User');
            $this->model = $userRepository->find($this->id);
        }
        return $this->model;
    }


    public function checkAccess($operation,$params=array(),$allowCaching=true)
    {
        if($allowCaching && $params===array() && isset($this->_access[$operation]))
            return $this->_access[$operation];

        $access=\Yii::app()->getModule('lms')->getModule('user')->authManager->checkAccess($operation,$this->getId(),$params);
        if($allowCaching && $params===array())
            $this->_access[$operation]=$access;

        return $access;
    }

}