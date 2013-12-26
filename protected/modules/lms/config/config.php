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
        'request' => array(
            'class' => 'RequestComponent'
        ),
        'doctrine'=>array(
            'class' => 'DoctrineComponent',
            'basePath' => __DIR__ . '/../',
            'proxyPath' => __DIR__ . '/../proxies',
            'entityPath' => array(
                __DIR__ . '/../entities'
            )
        ),
        'errorHandler'=>array(
            'errorAction'=>'lms/lms/error',
        ),
    ),
    'modules'=>array(
        'courses',
        'user'
    ),
);