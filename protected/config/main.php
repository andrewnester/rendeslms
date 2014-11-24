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
				'lms/user/login'=>'lms/user/default/login',
				'lms/user/logout'=>'lms/user/default/logout',
				'lms/user/register'=>'lms/user/default/register',
				'lms/user/activate'=>'lms/user/default/activate',

				'lms/courses/<courseID:\d+>/steps/<stepID:\d+>/lectures/<lectureID:\d+>/slides/play'=>'lms/courses/slides/index',

                'lms/courses/<courseID:\d+>/steps/<stepID:\d+>/lectures/<lectureID:\d+>/<controller:\w+>/<id:\d+>'=>'lms/courses/<controller>/view',
                'lms/courses/<courseID:\d+>/steps/<stepID:\d+>/lectures/<lectureID:\d+>/<controller:\w+>/<id:\d+>/<action:\w+>'=>'lms/courses/<controller>/<action>',
                'lms/courses/<courseID:\d+>/steps/<stepID:\d+>/lectures/<lectureID:\d+>/<controller:\w+>/<action:\w+>'=>'lms/courses/<controller>/<action>',

                'lms/courses/<courseID:\d+>/steps/<stepID:\d+>/quizzes/<quizID:\d+>/<controller:\w+>/<id:\d+>'=>'lms/courses/<controller>/view',
                'lms/courses/<courseID:\d+>/steps/<stepID:\d+>/quizzes/<quizID:\d+>/<controller:\w+>/<id:\d+>/<action:\w+>'=>'lms/courses/<controller>/<action>',
                'lms/courses/<courseID:\d+>/steps/<stepID:\d+>/quizzes/<quizID:\d+>/<controller:\w+>/<action:\w+>'=>'lms/courses/<controller>/<action>',

                'lms/courses/<courseID:\d+>/steps/<stepID:\d+>/<controller:\w+>/<id:\d+>'=>'lms/courses/<controller>/view',
                'lms/courses/<courseID:\d+>/steps/<stepID:\d+>/<controller:\w+>/<id:\d+>/<action:\w+>'=>'lms/courses/<controller>/<action>',
                'lms/courses/<courseID:\d+>/steps/<stepID:\d+>/<controller:\w+>/<action:\w+>/'=>'lms/courses/<controller>/<action>',


				'lms/user/<userID:\d+>/<module:(marks)>'=>'lms/user/<module>/default/index',
				'lms/user/<userID:\d+>/<module:(marks)>/<action:\w+>/<id:\d+>'=>'lms/user/<module>/default/<action>',
				'lms/user/<userID:\d+>/<module:(marks)>/<action:\w+>'=>'lms/user/<module>/default/<action>',
				'lms/user/<userID:\d+>/<module:(marks)>/<controller:\w+>/<itemID:\d+>/<action:\w+>/<id:\d+>'=>'lms/user/<module>/<controller>/<action>',
				'lms/user/<userID:\d+>/<module:(marks)>/<controller:\w+>/<itemID:\d+>/<action:\w+>'=>'lms/user/<module>/<controller>/<action>',
				'lms/user/<userID:\d+>/<module:(marks)>/<controller:\w+>/<action:\w+>'=>'lms/user/<module>/<controller>//<action>',

				'lms/user/<userID:\d+>'=>'lms/user/default/view',
				'lms/user/<userID:\d+>/<action:\w+>'=>'lms/user/default/<action>',


				'lms/user/<controller:\w+>'=>'lms/user/<controller>/index',
				'lms/user/<controller:\w+>/<id:\d+>'=>'lms/user/<controller>/view',
				'lms/user/<controller:\w+>/<action:\w+>'=>'lms/user/<controller>/<action>',

				'lms/<module:\w+>/<itemID:\d+>/<controller:\w+>/<id:\d+>'=>'lms/<module>/<controller>/view',
				'lms/<module:\w+>/<itemID:\d+>/<controller:\w+>/<action:\w+>'=>'lms/<module>/<controller>/<action>',
				'lms/<module:\w+>/<itemID:\d+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'lms/<module>/<controller>/<action>',


				'lms/<module:\w+>/<id:\d+>'=>'lms/<module>/default/view',
				'lms/<module:\w+>/<id:\d+>/<action:\w+>'=>'lms/<module>/default/<action>',
                'lms/<module:\w+>/<action:\w+>'=>'lms/<module>/default/<action>',
			),
		),

        'mail' => array(
            'class' => 'SwiftMailer',
            'fromEmail' => 'newaltgroup@bk.ru',
            'transportType'=>'smtp',
            'transportOptions'=>array(
                'host'=>'smtp.mail.ru',
                'username'=>'newaltgroup@bk.ru',
                'password'=>'andrew100000',
                'port'=>'25',
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