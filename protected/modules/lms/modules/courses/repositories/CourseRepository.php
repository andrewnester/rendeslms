<?php

namespace Rendes\Modules\Courses\Repositories;

class CourseRepository extends \Rendes\Components\LMSRepository
{
    protected $_id = 'CourseRepository';


    public function getByID($id)
    {
        $query = $this->getEntityManager()
                      ->createQuery('SELECT c
                                        FROM ' . $this->getEntityName() . ' c
                                        WHERE c.id=:id');
        $query->setParameter('id', $id);
        return $query->getSingleResult();
    }

      /**
     * Fetches the data from the persistent data storage.
     * @return array list of data items
     */
    protected function fetchData()
    {
        $criteria=clone $this->getCriteria();

        $qb = $this->_em->getRepository('\Rendes\Modules\Courses\Entities\Course')->createQueryBuilder('c');
        $qb->addSelect('partial t.{id, name}');
        $qb->join('c.teacher', 't');
        if(!empty($criteria->params)){
            $params = array_pop($criteria->params);
            $qb = $qb->where('c.'.$params['key'].$params['type'].':'.$params['key']);
            foreach($criteria->params as $params){
                $qb = $qb->andWhere('c.'.$params['key'].$params['type'].':'.$params['key']);
            }

            $criteria = $this->getCriteria();
            foreach($criteria->params as $params){
                $qb = $qb->setParameter($params['key'], $params['value']);
            }
        }

        $query = $qb->getQuery();
        $this->data = $query->getArrayResult();
        return $this->data;
    }

    /**
     * Calculates the total number of data items.
     * @return integer the total number of data items.
     */
    protected function calculateTotalItemCount()
    {
        $query = $this->_em->createQuery('SELECT COUNT(c.id) FROM \Rendes\Modules\Courses\Entities\Course c');
        return $query->getSingleScalarResult();
    }
}