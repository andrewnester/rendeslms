<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Modules\Courses\Interfaces\ResultRepositories;

interface IQuizResultRepository extends IResultRepository
{
    public function findQuizQuestionResult(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz);
    public function getAttemptCount(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user);
}