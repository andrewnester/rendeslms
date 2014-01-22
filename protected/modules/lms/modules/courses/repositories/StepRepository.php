<?php

namespace Rendes\Modules\Courses\Repositories;

use Doctrine\ORM\EntityRepository;

class StepRepository extends EntityRepository
{
    protected $_id = 'StepsRepository';

    public function getByCourseID($courseID)
    {
        $query = $this->getEntityManager()->createQuery('SELECT s FROM \Rendes\Modules\Courses\Entities\Step s WHERE s.course = :id');
        $query->setParameter('id', $courseID);
        return $query->getArrayResult();
    }

    public function getByID($id)
    {
        $query = $this->getEntityManager()->createQuery('SELECT s FROM \Rendes\Modules\Courses\Entities\Step s WHERE s.id = :id');
        $query->setParameter('id', $id);
        return $query->getSingleResult();
    }
}