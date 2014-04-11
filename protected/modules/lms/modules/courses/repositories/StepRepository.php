<?php

namespace Rendes\Modules\Courses\Repositories;
use \Rendes\Components\BaseRepository;

class StepRepository extends BaseRepository
{
    protected $_id = '\Rendes\Modules\Courses\Entities\Step';

    public function getByCourseID($courseID)
    {
        $query = $this->getEntityManager()->createQuery('SELECT s FROM \Rendes\Modules\Courses\Entities\Step s WHERE s.course = :id');
        $query->setParameter('id', $courseID);
        return $query->getArrayResult();
    }
}