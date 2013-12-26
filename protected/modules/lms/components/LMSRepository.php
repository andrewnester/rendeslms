<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 23.11.13
 * Time: 14:42
 * To change this template use File | Settings | File Templates.
 */
use Doctrine\ORM\EntityRepository;

abstract class LMSRepository extends EntityRepository implements IDataProvider
{
    protected $_id;
    private $_data;
    private $_keys;
    private $_totalItemCount;
    private $_sort;
    private $_pagination;

    public $modelClass;
    public $model;
    public $keyAttribute;

    private $_criteria;
    private $_countCriteria;

    public $data;

    /**
     * Fetches the data from the persistent data storage.
     * @return array list of data items
     */
    abstract protected function fetchData();
    /**
     * Calculates the total number of data items.
     * @return integer the total number of data items.
     */
    abstract protected function calculateTotalItemCount();

    /**
     * Returns the ID that uniquely identifies the data provider.
     * @return string the unique ID that uniquely identifies the data provider among all data providers.
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Returns the pagination object.
     * @param string $className the pagination object class name. Parameter is available since version 1.1.13.
     * @return CPagination|false the pagination object. If this is false, it means the pagination is disabled.
     */
    public function getPagination($className='CPagination')
    {
        if($this->_pagination===null)
        {
            $this->_pagination=new $className;
            if(($id=$this->getId())!='')
                $this->_pagination->pageVar=$id.'_page';
        }
        return $this->_pagination;
    }

    /**
     * Sets the pagination for this data provider.
     * @param mixed $value the pagination to be used by this data provider. This could be a {@link CPagination} object
     * or an array used to configure the pagination object. If this is false, it means the pagination should be disabled.
     *
     * You can configure this property same way as a component:
     * <pre>
     * array(
     *     'class' => 'MyPagination',
     *     'pageSize' => 20,
     * ),
     * </pre>
     */
    public function setPagination($value)
    {
        if(is_array($value))
        {
            if(isset($value['class']))
            {
                $pagination=$this->getPagination($value['class']);
                unset($value['class']);
            }
            else
                $pagination=$this->getPagination();

            foreach($value as $k=>$v)
                $pagination->$k=$v;
        }
        else
            $this->_pagination=$value;
    }

    /**
     * Sets the sorting for this data provider.
     * @param mixed $value the sorting to be used by this data provider. This could be a {@link CSort} object
     * or an array used to configure the sorting object. If this is false, it means the sorting should be disabled.
     *
     * You can configure this property same way as a component:
     * <pre>
     * array(
     *     'class' => 'MySort',
     *     'attributes' => array('name', 'weight'),
     * ),
     * </pre>
     */
    public function setSort($value)
    {
        if(is_array($value))
        {
            if(isset($value['class']))
            {
                $sort=$this->getSort($value['class']);
                unset($value['class']);
            }
            else
                $sort=$this->getSort();

            foreach($value as $k=>$v)
                $sort->$k=$v;
        }
        else
            $this->_sort=$value;
    }

    /**
     * Returns the data items currently available.
     * @param boolean $refresh whether the data should be re-fetched from persistent storage.
     * @return array the list of data items currently available in this data provider.
     */
    public function getData($refresh=false)
    {
        if($this->_data===null || $refresh)
            $this->_data=$this->fetchData();
        return $this->_data;
    }

    /**
     * Sets the data items for this provider.
     * @param array $value put the data items into this provider.
     */
    public function setData($value)
    {
        $this->_data=$value;
    }

    /**
     * Returns the key values associated with the data items.
     * @param boolean $refresh whether the keys should be re-calculated.
     * @return array the list of key values corresponding to {@link data}. Each data item in {@link data}
     * is uniquely identified by the corresponding key value in this array.
     */
    public function getKeys($refresh=false)
    {
        if($this->_keys===null || $refresh)
            $this->_keys=$this->fetchKeys();
        return $this->_keys;
    }

    /**
     * Sets the data item keys for this provider.
     * @param array $value put the data item keys into this provider.
     */
    public function setKeys($value)
    {
        $this->_keys=$value;
    }

    /**
     * Returns the number of data items in the current page.
     * This is equivalent to <code>count($provider->getData())</code>.
     * When {@link pagination} is set false, this returns the same value as {@link totalItemCount}.
     * @param boolean $refresh whether the number of data items should be re-calculated.
     * @return integer the number of data items in the current page.
     */
    public function getItemCount($refresh=false)
    {
        return count($this->getData($refresh));
    }

    /**
     * Returns the total number of data items.
     * When {@link pagination} is set false, this returns the same value as {@link itemCount}.
     * @param boolean $refresh whether the total number of data items should be re-calculated.
     * @return integer total number of possible data items.
     */
    public function getTotalItemCount($refresh=false)
    {
        if($this->_totalItemCount===null || $refresh)
            $this->_totalItemCount=$this->calculateTotalItemCount();
        return $this->_totalItemCount;
    }

    /**
     * Sets the total number of data items.
     * This method is provided in case when the total number cannot be determined by {@link calculateTotalItemCount}.
     * @param integer $value the total number of data items.
     * @since 1.1.1
     */
    public function setTotalItemCount($value)
    {
        $this->_totalItemCount=$value;
    }


    /**
     * Returns the query criteria.
     * @return CDbCriteria the query criteria
     */
    public function getCriteria()
    {
        if($this->_criteria===null)
            $this->_criteria=new CDbCriteria;
        return $this->_criteria;
    }

    /**
     * Sets the query criteria.
     * @param CDbCriteria|array $value the query criteria. This can be either a CDbCriteria object or an array
     * representing the query criteria.
     */
    public function setCriteria($value)
    {
        $this->_criteria=$value instanceof CDbCriteria ? $value : new CDbCriteria($value);
    }

    /**
     * Returns the count query criteria.
     * @return CDbCriteria the count query criteria.
     * @since 1.1.14
     */
    public function getCountCriteria()
    {
        if($this->_countCriteria===null)
            return $this->getCriteria();
        return $this->_countCriteria;
    }

    /**
     * Sets the count query criteria.
     * @param CDbCriteria|array $value the count query criteria. This can be either a CDbCriteria object
     * or an array representing the query criteria.
     * @since 1.1.14
     */
    public function setCountCriteria($value)
    {
        $this->_countCriteria=$value instanceof CDbCriteria ? $value : new CDbCriteria($value);
    }

    /**
     * Returns the sorting object.
     * @param string $className the sorting object class name. Parameter is available since version 1.1.13.
     * @return CSort the sorting object. If this is false, it means the sorting is disabled.
     */
    public function getSort($className='CSort')
    {
        if(($sort=$this->_getSort($className))!==false)
            $sort->modelClass=$this->modelClass;
        return $sort;

    }
    /**
     * Fetches the data item keys from the persistent data storage.
     * @return array list of data item keys.
     */
    protected function fetchKeys()
    {
        $keys=array();
        foreach($this->getData() as $i=>$entity)
        {
            $key=$this->keyAttribute===null ? $entity->getId()  : $entity->get{$this->keyAttribute}();
            $keys[$i]=is_array($key) ? implode(',',$key) : $key;
        }
        return $keys;
    }

    private function _getSort($className)
    {
        if($this->_sort===null)
        {
            $this->_sort=new $className;
            if(($id=$this->getId())!='')
                $this->_sort->sortVar=$id.'_sort';
        }
        return $this->_sort;
    }

}