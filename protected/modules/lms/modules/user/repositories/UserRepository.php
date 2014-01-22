<?php

namespace Rendes\Modules\User\Repositories;

class UserRepository extends \Rendes\Components\LMSRepository
{
    protected $_id = 'UserRepository';


    public function getTeachers()
    {
        $query = $this->getEntityManager()->createQuery('SELECT u FROM \Rendes\Modules\User\Entities\User u WHERE u.role IN (\'administrator\', \'teacher\')');
        return $query->getArrayResult();
    }

    /**
     * Fetches the data from the persistent data storage.
     * @return array list of data items
     */
    protected function fetchData()
    {
        $criteria=clone $this->getCriteria();

        $qb = $this->_em->getRepository("User")->createQueryBuilder('s');
        if(!empty($criteria->params)){
            $params = array_pop($criteria->params);
            $qb = $qb->where('s.'.$params['key'].$params['type'].':'.$params['key']);
            foreach($criteria->params as $params){
                $qb = $qb->andWhere('s.'.$params['key'].$params['type'].':'.$params['key']);
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
        $qb->select('count(s.id)');
        $qb->from('User','s');

        $count = $qb->getQuery()->getSingleScalarResult();
        return $count;
    }
}