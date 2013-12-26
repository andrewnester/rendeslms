<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 06.11.13
 * Time: 18:54
 * To change this template use File | Settings | File Templates.
 */

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class DoctrineComponent extends CComponent
{
    private $em = null;
    private $basePath;
    private $proxyPath;
    private $entityPath;

    public function init()
    {
        $this->initDoctrine();
    }

    public function initDoctrine()
    {
        Yii::setPathOfAlias('Doctrine', $this->getBasePath() . '/vendor/Doctrine');

        $cache = new Doctrine\Common\Cache\FilesystemCache($this->getBasePath() . '/cache');
        $config = new Configuration();
        //  $config->setMetadataCacheImpl($cache);


        $driverImpl = new AnnotationDriver(new AnnotationReader(), $this->getEntityPath());
        AnnotationRegistry::registerAutoloadNamespace('Doctrine\ORM\Mapping', $this->getBasePath() . '/vendor');

        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir($this->getProxyPath());
        $config->setProxyNamespace('Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $connectionOptions = array(
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => '',
            'host' => 'localhost',
            'dbname' => 'yiilms'
        );

        $this->em = EntityManager::create($connectionOptions, $config);
    }

    /**
     * @param mixed $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @return mixed
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param mixed $entityPath
     */
    public function setEntityPath($entityPath)
    {
        $this->entityPath = $entityPath;
    }

    /**
     * @return mixed
     */
    public function getEntityPath()
    {
        return $this->entityPath;
    }

    /**
     * @param mixed $proxyPath
     */
    public function setProxyPath($proxyPath)
    {
        $this->proxyPath = $proxyPath;
    }

    /**
     * @return mixed
     */
    public function getProxyPath()
    {
        return $this->proxyPath;
    }




    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }
}