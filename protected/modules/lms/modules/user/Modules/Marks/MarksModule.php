<?php

namespace Rendes\Modules\User\Modules\Marks;

class MarksModule extends \CWebModule
{
    public $controllerNamespace = 'Rendes\Modules\User\Modules\Marks\Controllers';

	public function init()
	{
        $config = require dirname(__FILE__) . '/config/config.php';
        $this->configure($config);
	}
}
