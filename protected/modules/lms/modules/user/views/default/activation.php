<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Вход на сайт';
$this->breadcrumbs=array(
	'Вход на сайт',
);
?>

<h1><?php echo Yii::t('user', 'Account activation') ?></h1>

<p><?php echo Yii::t('user', 'Activation link has been sent to your email. Please follow it to finish registration') ?></p>
