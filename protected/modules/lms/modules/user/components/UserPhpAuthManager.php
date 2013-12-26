<?php

class UserPhpAuthManager extends CPhpAuthManager{
    public function init(){
        if($this->authFile===null){
            $this->authFile=Yii::getPathOfAlias('application.modules.lms.modules.user.config.auth').'.php';
        }

        parent::init();

        if(!Yii::app()->getModule('lms')->getModule('user')->user->isGuest){
            $this->assign(Yii::app()->getModule('lms')->getModule('user')->user->role, Yii::app()->getModule('lms')->getModule('user')->user->id);
        }
    }
}