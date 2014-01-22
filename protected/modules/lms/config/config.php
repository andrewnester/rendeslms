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
        'request' => array(
            'class' => '\Rendes\Components\RequestComponent'
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