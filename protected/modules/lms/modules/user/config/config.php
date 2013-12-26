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
            'class' => 'DoctrineComponent',
            'basePath' => __DIR__ . '/../../../',
            'proxyPath' => __DIR__ . '/../proxies',
            'entityPath' => array(
                __DIR__ . '/../entities'
            )
        ),
        'authManager'=>array(
            'class'=>'UserPhpAuthManager',
            'defaultRoles' => array('guest'),
        ),

        'user'=>array(
            'class' => 'WebUser',
            'loginUrl'=>array('/lms/user/default/login'),
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),
    ),
    'modules'=>array(
        'courses',
    ),
);