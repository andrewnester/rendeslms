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
     * Displays the login page
     */
    public function actionRegister()
    {
        $user = new \Rendes\Modules\User\Entities\User;
        $user->scenario = 'register';

        $http = $this->getHttpClient();
        $userData = $http->getPost('Rendes_Modules_User_Entities_User');

        $this->performAjaxValidation($user);

        if($userData){
            $user->attributes = $userData;
            if($user->validate()){
                $userService = new \Rendes\Modules\User\Services\UserService();
                $entityManager = $this->getEntityManager();
                $user = $userService->populate($user, $userData);


                $entityManager->persist($user);
                $entityManager->flush();

                $userService->sendActivationLink($user, $this->createAbsoluteUrl('/lms/user/activate'));

                $this->redirect('default/activation');
            }
        }
        // display the login form
        $this->render('register', array('model'=>$user));
    }


    public function actionActivate($code)
    {
        $entityManager = $this->getEntityManager();
        try{
            $userToActivate = $entityManager->getRepository('Rendes\Modules\User\Entities\User')
                                            ->findByActivateCode($code);
        }catch(\Exception $e){
            $this->render('failed');
            die();
        }


        $userToActivate->setActivateCode('');
        $userToActivate->setActivated(true);

        $userService = new \Rendes\Modules\User\Services\UserService();
        $userService->registerInLRS($userToActivate);

        $entityManager->flush();

        $this->render('activated');
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax'])){
            echo \CActiveForm::validate($model);
            \Yii::app()->end();
        }
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