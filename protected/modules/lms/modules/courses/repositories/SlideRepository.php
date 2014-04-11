<?php

namespace Rendes\Modules\Courses\Repositories;
use \Rendes\Components\BaseRepository;

class SlideRepository extends BaseRepository
{
    protected $_id = '\Rendes\Modules\Courses\Entities\Lecture\Slide';

	public function getByLectureID($lectureID)
	{
		$query = $this->getEntityManager()->createQuery('SELECT s FROM '.$this->_id.' s WHERE s.lecture = :id');
		$query->setParameter('id', $lectureID);
		return $query->getArrayResult();
	}
}