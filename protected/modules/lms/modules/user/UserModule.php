<?php

class UserModule extends CWebModule
{
	public function init()
	{
        $config = require dirname(__FILE__) . '/config/config.php';
        $this->configure($config);

        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'user.entities.*',
            'user.proxies.*',
            'user.components.*',
            'user.controllers.*',
            'user.services.*',
            'user.forms.*',
            'user.repositories.*'
        ));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
