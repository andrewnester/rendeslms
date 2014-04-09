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
            'basePath' => __DIR__ . '/../../../',
            'proxyPath' => __DIR__ . '/../proxies',
            'entityPath' => array(
                __DIR__ . '/../entities',
                __DIR__ . '/../entities/quiz',
                __DIR__ . '/../entities/quiz/question',
                __DIR__ . '/../entities/lecture',
                __DIR__ . '/../../user/entities'
            ),
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => '',
            'host' => 'localhost',
            'dbname' => 'yiilms'
        ),
		'quizStartValidator' => array(
			'class' => '\Rendes\Modules\Courses\Services\Quiz\Validators\QuizStartValidator'
		)
    ),

    'params' => array(
        'resultRepositories' => array(
            'quiz' => '\Rendes\Modules\Courses\Repositories\ResultRepositories\XAPI\QuizResultRepository',
            'question' => '\Rendes\Modules\Courses\Repositories\ResultRepositories\XAPI\QuestionResultRepository'
        ),
		'quizTypes' => array(
			array('class' => '\Rendes\Modules\Courses\Entities\Quiz\CountAnsweredQuiz', 'name' => 'Count Answered'),
			array('class' => '\Rendes\Modules\Courses\Entities\Quiz\PointsReceivedQuiz', 'name' => 'Points Received'),
		),
		'questionTypes' => array(
			array('class' => '\Rendes\Modules\Courses\Entities\Quiz\Questions\Question', 'name' => 'Simple Question'),
			array('class' => '\Rendes\Modules\Courses\Entities\Quiz\Questions\VariantQuestion', 'name' => 'Variant Question'),
		),
    ),
);