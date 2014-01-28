<?php

namespace Rendes\Modules\Courses\Repositories;

use Doctrine\ORM\EntityRepository;

class DocumentRepository extends EntityRepository
{
    protected $_id = 'DocumentRepository';

    public function getByID($id)
    {
        $query = $this->getEntityManager()->createQuery('SELECT d FROM \Rendes\Modules\Courses\Entities\Lecture\Document d WHERE d.id = :id');
        $query->setParameter('id', $id);
        return $query->getSingleResult();
    }

}