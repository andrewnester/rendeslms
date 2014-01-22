<?php

namespace Rendes\Modules\User;

class UserModule extends \CWebModule
{
    public $controllerNamespace = 'Rendes\Modules\User\Controllers';

	public function init()
	{
        $config = require dirname(__FILE__) . '/config/config.php';
        $this->configure($config);
	}

}
