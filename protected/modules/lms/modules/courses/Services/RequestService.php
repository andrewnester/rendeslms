<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;

class RequestService
{
    /**
     * @var \Rendes\Components\HttpClientComponent
     */
    private $request;
    private $searchData = array();

	public function __construct()
	{
		$this->request = new \Rendes\Components\HttpClientComponent();
	}

	public function getLimit()
	{
		return 10;
	}

    public function prepareSearchCriteria($isAdmin = false)
    {
        $criteria = new \CDbCriteria();
        $likeParams = array('name', 'description');

        $courseParams = $this->getData('Grid');

        $searchParams = array();
        foreach($courseParams as $key=>$value){
            if(strlen($value) > 0){
                $searchParams[] = array(
                    'key' => $key,
                    'value' => in_array($key, $likeParams) ? '%' . $value . '%' : $value,
                    'type' => in_array($key, $likeParams) ? ' LIKE ' : ' = ',
                );
            }
        }

        if(!$isAdmin){
            $searchParams[] = array(
                'key' => 'isPublic',
                'value' => 1,
                'type' => ' = ',
            );
        }

        $criteria->params = $searchParams;

        return $criteria;
    }

	public function prepareLimit($criteria)
	{
		$criteria->limit = $this->getLimit();
		$page = $this->request->get('page', -1);
		$criteria->offset = $page != -1 ? ($page-1)*$criteria->limit : -1;

		return $criteria;
	}

    public function getData($name, $default = array())
    {
        if(!isset($this->searchData[$name])){
           $this->searchData[$name] = $this->request->get($name, $default);
        }

        return $this->searchData[$name];
    }
}