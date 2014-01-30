<?php
/**
 * User: nester_a
 * Date: 28.01.14
 */

namespace Rendes\Widgets;

class AjaxLoadOnRadioChangeWidget extends \CWidget
{
    public $name = null;
    public $items = array();
    public $path = '';

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
        include __DIR__ . "/ajax_load/content.phtml";
    }

    public function renderScript()
    {
        include __DIR__ . "/ajax_load/header.phtml";
    }


    private function registerClientScript()
    {
        \Yii::app()->clientScript->registerCoreScript('jquery');
    }


}