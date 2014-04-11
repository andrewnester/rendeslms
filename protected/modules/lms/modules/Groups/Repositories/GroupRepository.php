<?php

namespace Rendes\Modules\Groups\Repositories;

class GroupRepository extends \Rendes\Components\LMSRepository
{
    protected $_id = '\Rendes\Modules\Groups\Entities\Group';


      /**
     * Fetches the data from the persistent data storage.
     * @return array list of data items
     */
    protected function fetchData()
    {
        $criteria=clone $this->getCriteria();

		if(($pagination=$this->getPagination())!==false)
		{
			$pagination->setItemCount($this->getTotalItemCount());
			$pagination->applyLimit($criteria);
			$pagination->route = 'search';
		}


		$qb = $this->_em->getRepository('\Rendes\Modules\Groups\Entities\Group')->createQueryBuilder('c');
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
		if($criteria->limit > 0){
			$qb->setMaxResults($criteria->limit);
		}

		if($criteria->offset > 0){
			$qb->setFirstResult($criteria->offset);
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
		$qb = $this->_em->getRepository('\Rendes\Modules\Groups\Entities\Group')->createQueryBuilder('c')->select('COUNT(c.id)');
		$criteria=clone $this->getCriteria();
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
        return $query->getSingleScalarResult();
    }
}