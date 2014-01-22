<?php

class SiteController extends Controller
{

	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionError()
    {
        if($error = Yii::app()->errorHandler->error){
            $this->render('error', array('error' => $error));
        }
    }
}