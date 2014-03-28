<?php

namespace Rendes\Modules\Courses\Interfaces\Quiz;

use Rendes\Modules\Courses\Entities\Quiz\Quiz;
use Rendes\Modules\User\Entities\User;

interface IQuizStartValidator
{
	public function validate(Quiz $quiz, User $user);
}