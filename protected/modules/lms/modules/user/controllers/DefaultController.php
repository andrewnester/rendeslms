<?php

namespace Rendes\Modules\User\Controllers;

class DefaultController extends \Rendes\Controllers\LMSController
{

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }


    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=\Yii::app()->errorHandler->error)
        {
            if(\Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model=new \Rendes\Modules\User\Forms\LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo \CActiveForm::validate($model);
            \Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['Rendes_Modules_User_Forms_LoginForm']))
        {
            $model->attributes=$_POST['Rendes_Modules_User_Forms_LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(\Yii::app()->controller->module->user->returnUrl);
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        \Yii::app()->user->logout();
        $this->redirect(\Yii::app()->homeUrl);
    }

}