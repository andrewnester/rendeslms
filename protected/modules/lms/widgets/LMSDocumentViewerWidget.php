<?php
/**
 * User: nester_a
 * Date: 10.04.14
 */

namespace Rendes\Widgets;

class LMSDocumentViewerWidget extends \CWidget
{
	public $src='';



	public function run()
	{
		$this->renderContent();
	}

	public function renderContent()
	{
		include __DIR__ . "/documentviewer/content.phtml";
	}


}