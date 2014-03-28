<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 18.11.13
 * Time: 16:32
 * To change this template use File | Settings | File Templates.
 */


return array(
    'components' => array(
        'doctrine'=>array(
            'class' => '\Rendes\Components\DoctrineComponent',
            'basePath' => __DIR__ . '/../',
            'proxyPath' => __DIR__ . '/../Proxies',
            'entityPath' => array(
                __DIR__ . '/../Entities'
            ),
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => '',
            'host' => 'localhost',
            'dbname' => 'yiilms'
        ),
        'http' => array(
            'class' => '\Rendes\Components\HttpClientComponent'
        ),
        'xapi' => array(
            'class' => '\Rendes\Components\XAPIComponent',
            'baseUrl' => 'http://localhost:3000/xapi/',
            'clientID' => 'mobileV1',
            'clientSecret' => 'abc123456'
        ),
		'quizValidator' => array(
			'class' => '\Rendes\Modules\Course\Services\Quiz\Validators\QuizStartValidator'
		)
    ),

    'params' => array(
        'resultRepositories' => array(
            'lectures' => '\Rendes\Modules\Courses\Repositories\LectureResultRepository'
        ),
        'namespaces' => array(
            'questions' => array(
                'widgets' => '\Rendes\Modules\Courses\Widgets\Questions'
            )
        ),
    ),
    'modules'=>array(
        'courses' => array(
            'class' => '\Rendes\Modules\Courses\CoursesModule'
        ),
        'user'=> array(
            'class' => '\Rendes\Modules\User\UserModule'
        ),
    ),
);