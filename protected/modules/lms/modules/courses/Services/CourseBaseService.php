<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Modules\Courses\Services;

abstract class CourseBaseService extends \Rendes\Services\BaseService
{

	private $repositories = array();

	abstract public function getResultRepository();

	public function init(){

	}

    protected function loadResultRepository($name)
    {
		if(isset($this->repositories[$name])){
			return $this->repositories[$name];
		}

        $repositoryName = \Yii::app()->getModule('lms')->getModule('courses')->params->resultRepositories[$name];
		$this->repositories[$name] = new $repositoryName();
		return $this->repositories[$name];
    }

	public function countOrder($orderArray, $elementID)
	{
		$orderCount = count($orderArray);
		for($i=0; $i<$orderCount; $i++){
			if($elementID == $orderArray[$i]){
				return $i+1;
			}
		}

		return 0;
	}

	public function getService($name)
	{
		return \Yii::app()->getModule('lms')->getModule('courses')->$name;
	}
}