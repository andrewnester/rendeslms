<?php

namespace Rendes\Modules\Courses\Repositories;

use Doctrine\ORM\EntityRepository;

class LectureRepository extends EntityRepository
{
    protected $_id = 'LectureRepository';

    public function getByID($id)
    {
        $query = $this->getEntityManager()->createQuery('SELECT l FROM \Rendes\Modules\Courses\Entities\Lecture\Lecture l WHERE l.id = :id');
        $query->setParameter('id', $id);
        return $query->getSingleResult();
    }

    public function getByIDArray($idArray)
    {
        $query = $this->getEntityManager()->createQuery('SELECT l FROM \Rendes\Modules\Courses\Entities\Lecture\Lecture l WHERE l.id IN (:ids)');
        $query->setParameter('ids', $idArray);
        return $query->getResult();
    }
}