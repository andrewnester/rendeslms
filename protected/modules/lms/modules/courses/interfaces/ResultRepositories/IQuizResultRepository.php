<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Modules\Courses\Interfaces\ResultRepositories;

interface IQuizResultRepository extends IResultRepository
{
    public function getAttemptCount(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user);
	public function getAnsweredQuestions(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user, $sessionID);
	public function getRightAnsweredQuestions(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user, $sessionID);
	public function getAttempts(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user);
}