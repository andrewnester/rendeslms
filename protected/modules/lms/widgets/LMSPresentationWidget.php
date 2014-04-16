<?php
/**
 * User: nester_a
 * Date: 10.04.14
 */

namespace Rendes\Widgets;

class LMSPresentationWidget extends \CWidget
{
	public $slides = array();
	public $courseID = '';
	public $stepID = '';
	public $lectureID = '';
	public $theme = 'beige';

	public function init()
	{
		$this->registerClientScript();
	}


	public function run()
	{
		$this->renderContent();
	}

	public function renderContent()
	{
		include __DIR__ . "/presentation/content.phtml";
	}


	private function registerClientScript()
	{
		\Yii::app()->clientScript->registerCoreScript('jquery');

		\Yii::app()->clientScript->registerScriptFile(
			\Yii::app()->assetManager->publish(
				__DIR__.'/../assets/js/reveal.min.js'
			)
		);

		\Yii::app()->clientScript->registerCssFile(
			\Yii::app()->assetManager->publish(
				__DIR__.'/../assets/css/reveal.min.css'
			)
		);

		\Yii::app()->clientScript->registerCssFile(
			\Yii::app()->assetManager->publish(
				__DIR__.'/../assets/css/theme/'.$this->theme.'.css'
			)
		);
	}
}