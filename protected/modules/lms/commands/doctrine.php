<?php



// change the following paths if necessary
$yii = __DIR__ .'/../../../../framework/yii.php';
$config = __DIR__ . '/../config/console.php';

require_once($yii);
Yii::createWebApplication($config);
Yii::setPathOfAlias('Symfony', Yii::getPathOfAlias('application.modules.lms.vendor.Symfony'));

$em = Yii::app()->doctrine->getEntityManager();
// Создаем набор хелперов Doctrine (HelperSet)
$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);