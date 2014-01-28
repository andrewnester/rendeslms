<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 18.11.13
 * Time: 16:32
 * To change this template use File | Settings | File Templates.
 */
Yii::setPathOfAlias('Rendes', __DIR__.'/../');

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..',
    'import'=>array(
        'application.modules.lms.components.*',
    ),

    'components' => array(
        'doctrine'=>array(
            'class' => '\Rendes\Components\DoctrineComponent',
            'basePath' => __DIR__ . '/../',
            'entityPath' => array(
                __DIR__ . '/../entities'
            )
        ),
    ),
);