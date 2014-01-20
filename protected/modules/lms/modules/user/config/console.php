<?php
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..',
    'import'=>array(
        'application.modules.lms.modules.user.components.*',
    ),

    'components' => array(
        'doctrine'=>array(
            'class' => 'DoctrineComponent',
            'basePath' => __DIR__ . '/../../../',
            'proxyPath' => __DIR__ . '/../proxies',
            'entityPath' => array(
                __DIR__ . '/../entities'
            ),
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => '',
            'host' => 'localhost',
            'dbname' => 'yiilms'
        ),
    ),
);