<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Modules\Courses\Interfaces\Services;

use \Rendes\Modules\User\Entities\Student;

interface ILearningActivityService
{
	public function isAvailableToStart($activityObject, \Rendes\Modules\User\Entities\Student $student);
	public function isPassed($activityObject, \Rendes\Modules\User\Entities\Student $student);
	public function isFailed($activityObject, \Rendes\Modules\User\Entities\Student $student);
	public function isActive($activityObject, \Rendes\Modules\User\Entities\Student $student);
	public function currentProgress($activityObject, \Rendes\Modules\User\Entities\Student $student);
}