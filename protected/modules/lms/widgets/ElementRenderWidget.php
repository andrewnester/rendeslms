<?php
/**
 * User: nester_a
 * Date: 28.01.14
 */

namespace Rendes\Widgets;

class ElementRenderWidget extends \CWidget
{

    public $model = null;
    public $name = null;
    public $header = null;
    public $link = null;
    public $order = true;
    public $linkParams = array();

    public function run()
    {
        $this->renderContent();
    }

    public function renderContent()
    {
        include __DIR__ . "/element_render/content.phtml";
    }


}