<?php

namespace Rendes\Modules\User\Components;

class UserPhpAuthManager extends \CPhpAuthManager{
    public function init(){
        if($this->authFile===null){
            $this->authFile=\Yii::getPathOfAlias('application.modules.lms.modules.user.config.auth').'.php';
        }

        parent::init();

        $user = \Yii::app()->getModule('lms')->getModule('user')->user;
        if(!$user->isGuest){
            if($user->getEntity()->getActivated()){
                $this->assign(\Yii::app()->getModule('lms')->getModule('user')->user->role, \Yii::app()->getModule('lms')->getModule('user')->user->id);
            }
        }
    }
}