<?php
/**
 * User: nester_a
 * Date: 28.01.14
 */

namespace Rendes\Widgets;

class SortableListWidget extends \CWidget
{

    public $path = null;
    public $items = array();
    public $id = null;
    public $width = 200;
    public $header = null;

    public function init()
    {
        $this->registerClientScript();
    }

    public function run()
    {
        $this->renderScript();
        $this->renderContent();
    }

    public function renderContent()
    {
        include __DIR__ . "/sortable/content.phtml";
    }

    public function renderScript()
    {
        include __DIR__ . "/sortable/header.phtml";
    }



    private function registerClientScript()
    {
        $baseUrl = \Yii::app()->baseUrl;
        $cs = \Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl.'/assets/js/jquery.ui.js');
        $cs->registerScriptFile($baseUrl.'/assets/js/sortable.list.js');
        $cs->registerCssFile($baseUrl.'/assets/css/sortable.list.css');
        $cs->registerCssFile($baseUrl.'/assets/css/nice-button.css');
    }
}