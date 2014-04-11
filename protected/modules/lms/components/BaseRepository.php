<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */
namespace Rendes\Components;
use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository
{
	protected $_id = '';

	public function getByIDArray($idArray)
	{
		$query = $this->getEntityManager()->createQuery('SELECT l FROM '.$this->getEntityName().' l WHERE l.id IN (:ids)');
		$query->setParameter('ids', $idArray);
		return $query->getResult();
	}

	public function getByID($id)
	{
		$query = $this->getEntityManager()->createQuery('SELECT d FROM '.$this->getEntityName().' d WHERE d.id = :id');
		$query->setParameter('id', $id);
		return $query->getSingleResult();
	}
}