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
            ),
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => '',
            'host' => 'localhost',
            'dbname' => 'yiilms'
        ),
    )
);