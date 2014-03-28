<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Modules\Courses\Services;

abstract class CourseBaseService extends \Rendes\Services\BaseService
{
	public abstract function getResultRepository();

    protected function loadResultRepository($name)
    {
        $repositoryName = \Yii::app()->getModule('lms')->getModule('courses')->params->resultRepositories[$name];
        return new $repositoryName();
    }
}