<?php

namespace Rendes\Modules\Courses\Repositories;

use Doctrine\ORM\EntityRepository;

class QuizRepository extends EntityRepository
{
    protected $_id = 'QuizRepository';

    public function getByID($id)
    {
        $query = $this->getEntityManager()->createQuery('SELECT q FROM \Rendes\Modules\Courses\Entities\Quiz\Quiz q WHERE q.id = :id');
        $query->setParameter('id', $id);
        return $query->getSingleResult();
    }

    public function getAvailableCalculators()
    {
        return array(
            ''
        );
    }
}