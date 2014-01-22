<?php

namespace Rendes\Modules\Courses;

class CoursesModule extends \CWebModule
{
    public $controllerNamespace = 'Rendes\Modules\Courses\Controllers';

	public function init()
	{
        $config = require dirname(__FILE__) . '/config/config.php';
        $this->configure($config);
	}
}
