<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 18.11.13
 * Time: 16:32
 * To change this template use File | Settings | File Templates.
 */
Yii::setPathOfAlias('Rendes', __DIR__ . '/../../../');

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..',
    'components' => array(
        'doctrine'=>array(
            'class' => '\Rendes\Components\DoctrineComponent',
            'basePath' => __DIR__ . '/../../../',
            'proxyPath' => __DIR__ . '/../Proxies',
            'entityPath' => array(
                __DIR__ . '/../Entities',
                __DIR__ . '/../Entities/Quiz',
                __DIR__ . '/../Entities/Quiz/Questions',
                __DIR__ . '/../Entities/Lecture',
                __DIR__ . '/../../User/Entities',
				__DIR__ . '/../../Groups/Entities'
            ),
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => '',
            'host' => 'localhost',
            'dbname' => 'yiilms'
        ),
    ),
);