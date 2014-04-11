<?php

namespace Rendes\Modules\Courses\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use \Rendes\Components\BaseRepository;

class QuestionRepository extends EntityRepository
{
    protected $_id = 'QuestionRepository';

    public function getArrayResultByID($id)
    {
        $query = $this->getEntityManager()->createQuery('SELECT q FROM \Rendes\Modules\Courses\Entities\Quiz\Questions\Question q WHERE q.id = :id');
        $query->setParameter('id', $id);
        return $query->getSingleResult(Query::HYDRATE_ARRAY);
    }

    public function getByID($id)
    {
        $query = $this->getEntityManager()->createQuery('SELECT q FROM \Rendes\Modules\Courses\Entities\Quiz\Questions\Question q WHERE q.id = :id');
        $query->setParameter('id', $id);
        return $query->getSingleResult();
    }

	public function getByIDArray($idArray)
	{
		$query = $this->getEntityManager()->createQuery('SELECT q FROM \Rendes\Modules\Courses\Entities\Quiz\Questions\Question q WHERE q.id IN (:ids)');
		$query->setParameter('ids', $idArray);
		return $query->getResult();
	}
}