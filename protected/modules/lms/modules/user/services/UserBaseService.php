<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\User\Services;

abstract class UserBaseService extends \Rendes\Services\BaseService
{
	/**
	 * @param $name
	 * @return mixed
	 */
	public function getService($name)
	{
		return \Yii::app()->getModule('lms')->getModule('courses')->$name;
	}
}