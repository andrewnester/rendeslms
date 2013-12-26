<?php

class CoursesModule extends CWebModule
{
	public function init()
	{
        $config = require dirname(__FILE__) . '/config/config.php';
        $this->configure($config);

		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'courses.entities.*',
			'courses.proxies.*',
            'courses.components.*',
            'courses.repositories.*',
            'application.modules.lms.modules.user.entities.*'
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
