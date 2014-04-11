<?php

namespace Rendes\Modules\Groups;

class GroupsModule extends \CWebModule
{
    public $controllerNamespace = 'Rendes\Modules\Groups\Controllers';

	public function init()
	{
        $config = require dirname(__FILE__) . '/config/config.php';
        $this->configure($config);
	}
}
