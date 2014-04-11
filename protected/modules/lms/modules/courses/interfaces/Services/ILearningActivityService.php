<?php
/**
 * User: nester_a
 * Date: 09.04.14
 */

namespace Rendes\Modules\Courses\Interfaces\Services;

use \Rendes\Modules\User\Entities\User;

interface ILearningActivityService
{
	public function isAvailableToStart($activityObject, User $user);
	public function isPassed($activityObject, User $user);
	public function currentProgress($activityObject, User $user);
}