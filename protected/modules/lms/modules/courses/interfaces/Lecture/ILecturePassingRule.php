<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Modules\Courses\Interfaces\Lecture;
use \Rendes\Modules\Courses\Interfaces\ResultRepositories as ResultRepositories;

interface ILecturePassingRule
{
    public function validate(ResultRepositories\ILectureResultRepository $repository);
}