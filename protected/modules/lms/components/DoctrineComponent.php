<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 06.11.13
 * Time: 18:54
 * To change this template use File | Settings | File Templates.
 */

namespace Rendes\Components;

use \Doctrine\ORM\EntityManager;
use \Doctrine\ORM\Configuration;
use \Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use \Doctrine\Common\Annotations\AnnotationReader;
use \Doctrine\Common\Annotations\AnnotationRegistry;

class DoctrineComponent extends \CComponent
{
    private $em = null;
    private $basePath;
    private $proxyPath;
    private $entityPath;
    private $driver;
    private $user;
    private $password;
    private $host;
    private $dbname;


    public function init()
    {
        $this->initDoctrine();
    }

    public function initDoctrine()
    {
        \Yii::setPathOfAlias('Doctrine', $this->getBasePath() . '/vendor/Doctrine');

        $cache = new \Doctrine\Common\Cache\FilesystemCache($this->getBasePath() . '/cache');
        $config = new Configuration();

        $driverImpl = new AnnotationDriver(new AnnotationReader(), $this->getEntityPath());
        AnnotationRegistry::registerAutoloadNamespace('Doctrine\ORM\Mapping', $this->getBasePath() . '/vendor');

     //   $config->setMetadataCacheImpl($cache);
        $config->setMetadataDriverImpl($driverImpl);
       // $config->setQueryCacheImpl($cache);
        $config->setProxyDir($this->getProxyPath());
        $config->setProxyNamespace('Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $connectionOptions = array(
            'driver' => $this->getDriver(),
            'user' => $this->getUser(),
            'password' => $this->getPassword(),
            'host' => $this->getHost(),
            'dbname' => $this->getDbname()
        );

        $this->em = EntityManager::create($connectionOptions, $config);
    }


    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function setEntityPath($entityPath)
    {
        $this->entityPath = $entityPath;
    }

    public function getEntityPath()
    {
        return $this->entityPath;
    }

    public function setProxyPath($proxyPath)
    {
        $this->proxyPath = $proxyPath;
    }

    public function getProxyPath()
    {
        return $this->proxyPath;
    }

    public function setDbname($dbname)
    {
        $this->dbname = $dbname;
    }

    public function getDbname()
    {
        return $this->dbname;
    }

    public function setDriver($driver)
    {
        $this->driver = $driver;
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }



    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }
}