<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Services;

class BaseService
{
    private $entityManager;

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if(is_null($this->entityManager)){
            $this->entityManager = \Yii::app()->controller->module->doctrine->getEntityManager();
        }
        return $this->entityManager;
    }
}