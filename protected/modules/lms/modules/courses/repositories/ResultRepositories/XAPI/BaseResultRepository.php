<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Modules\Courses\Repositories\ResultRepositories\XAPI;

abstract class BaseResultRepository
{
    /**
     * @return \Rendes\Components\XAPIComponent
     */
    public function getXAPI()
    {
        return \Yii::app()->getModule('lms')->xapi;
    }

    /**
     * @param array $statement
     * @return bool
     */
    public function recordStatement($statement)
    {
        $xapi = $this->getXAPI();
        return $xapi->postStatement($statement);
    }
}