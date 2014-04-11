<?php
/**
 * User: nester_a
 * Date: 10.04.14
 */

namespace Rendes\Widgets;

class LMSVideoWidget extends \CWidget
{
	public $src = '';

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
		$type = explode('.', $this->src);
		$type = 'video/' . (isset($type[1]) ? $type[1] : 'mp4');
		include __DIR__ . "/video/content.phtml";
	}


	private function registerClientScript()
	{
		\Yii::app()->clientScript->registerScriptFile(
			\Yii::app()->assetManager->publish(
				__DIR__.'/../assets/js/video.js'
			)
		);
		\Yii::app()->clientScript->registerCssFile(
			\Yii::app()->assetManager->publish(
				__DIR__.'/../assets/css/video-js.css'
			)
		);
	}
}