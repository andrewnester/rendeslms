<?php

namespace Rendes\Modules\User\Modules\Marks\Repositories;

use Doctrine\ORM\EntityRepository;

class MarkRepository extends EntityRepository
{
    protected $_id = '\Rendes\Modules\User\Modules\Marks\Entities\Mark';

	public function getMark(\Rendes\Modules\Courses\Entities\Step $step, \Rendes\Modules\User\Entities\Student $student)
	{
		$query = $this->getEntityManager()
						->createQuery('SELECT c.mark FROM ' . $this->getEntityName() . ' c
                                        WHERE c.student=:student AND c.step=:step');
		$query->setParameter('student', $student);
		$query->setParameter('step', $step);

		try{
			$mark = $query->getSingleScalarResult();
		}catch(\Doctrine\ORM\NoResultException $e){
			$mark = 0;
		}

		return $mark;
	}

	public function getMarkObject(\Rendes\Modules\Courses\Entities\Step $step, \Rendes\Modules\User\Entities\Student $student)
	{
		$query = $this->getEntityManager()
					  ->createQuery('SELECT c FROM ' . $this->getEntityName() . ' c
                                        WHERE c.student=:student AND c.step=:step');
		$query->setParameter('student', $student);
		$query->setParameter('step', $step);

		try{
			$mark = $query->getSingleResult();
		}catch(\Doctrine\ORM\NoResultException $e){
			$mark = null;
		}

		return $mark;
	}

}