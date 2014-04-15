<?php

namespace Rendes\Modules\Courses\Services\Quiz\Validators;

use Rendes\Modules\Courses\Interfaces\Quiz\IQuizStartValidator;
use Rendes\Modules\Courses\Entities\Quiz\Quiz;
use Rendes\Modules\Courses\Services\CourseBaseService;
use Rendes\Modules\User\Entities\User;
use Rendes\Modules\Courses\Interfaces as Interfaces;

class CountAnsweredQuizValidator extends CourseBaseService implements IQuizStartValidator
{
	public function init(){}

	public function validate(Quiz $quiz, User $user)
	{

		$attempts = $this->getResultRepository()->getAttempts($quiz, $user);
		foreach($attempts as $attempt){
			$sessionID = $attempt->context->registration;
			$rightAnswered = $this->getResultRepository()->getRightAnsweredQuestions($quiz, $user, $sessionID);
			if(count($rightAnswered) >= $quiz->getNeedCount()){
				return true;
			}
		}
		return false;
	}

	/**
	 * @return Interfaces\ResultRepositories\IQuizResultRepository
	 */
	public function getResultRepository()
	{
		return $this->loadResultRepository('quiz');
	}
}