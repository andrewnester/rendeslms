<?php

namespace Rendes;

\Yii::setPathOfAlias('Doctrine', __DIR__ . '/vendor/Doctrine');

class LmsModule extends \CWebModule
{
    public $controllerNamespace = 'Rendes\Controllers';

	public function init()
	{
        $config = require dirname(__FILE__) . '/config/config.php';
        $this->configure($config);
	}
}
