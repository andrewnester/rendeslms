<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('Rendes', __DIR__.'/../modules/lms/');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Rendes LMS',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'lms' => array(
            'class' => '\Rendes\LmsModule',
        ),
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'andrew10',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),

	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
                'lms/courses/<id:\d+>'=>'lms/courses/default/view',
                'lms/courses/<id:\d+>/<action:\w+>'=>'lms/courses/default/<action>',
                'lms/courses/<courseID:\d+>/<controller:\w+>/<id:\d+>'=>'lms/courses/<controller>/view',
                'lms/courses/<courseID:\d+>/<controller:\w+>/<action:(create|update|delete)>/<id:\d+>'=>'lms/courses/<controller>/<action>',
                'lms/courses/<courseID:\d+>/<controller:\w+>/<action:\w+>'=>'lms/courses/<controller>/<action>',
                'lms/<module:\w+>/<action:\w+>'=>'lms/<module>/default/<action>',
			),
		),


        'errorHandler'=>array(
            'errorAction'=>'site/error',
        ),
        'clientScript'=>array(
            'packages'=>array(
                'json-grid-view'=>array(
                    'baseUrl'=> 'assets/js/',
                    'js'=>array('jquery.json.yiigridview.js', 'jquery.jqote2.min.js'),
                ),
            ),
        ),
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=yiilms',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'bh_'
        ),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);