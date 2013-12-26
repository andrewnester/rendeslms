<?php

class CourseRepository extends LMSRepository
{
    protected $_id = 'CourseRepository';

      /**
     * Fetches the data from the persistent data storage.
     * @return array list of data items
     */
    protected function fetchData()
    {
        $criteria=clone $this->getCriteria();

        $qb = $this->_em->getRepository("Course")->createQueryBuilder('c');
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
        $this->data = $query->getResult();
        return $this->data;
    }

    /**
     * Calculates the total number of data items.
     * @return integer the total number of data items.
     */
    protected function calculateTotalItemCount()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(c.id)');
        $qb->from('Course','c');

        $count = $qb->getQuery()->getSingleScalarResult();
        return $count;
    }
}