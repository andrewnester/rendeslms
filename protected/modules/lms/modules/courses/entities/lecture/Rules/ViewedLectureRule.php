<?php
/**
 * User: nester_a
 * Date: 27.01.14
 */
namespace Rendes\Modules\Courses\Entities\Lecture\Rules;

use \Rendes\Modules\Courses\Interfaces as Interfaces;

class ViewedLectureRule implements Interfaces\Lecture\ILecturePassingRule
{
    public function validate( Interfaces\ResultRepositories\ILectureResultRepository $repository, $options=array())
    {
        // TODO: Implement validate() method.

        return true;
    }

}