<?php

namespace Rendes\Modules\Courses\Services\Quiz\Validators;

use Rendes\Modules\Courses\Interfaces\Quiz\IQuizStartValidator;
use Rendes\Modules\Courses\Entities\Quiz\Quiz;
use Rendes\Modules\Courses\Services\CourseBaseService;
use Rendes\Modules\User\Entities\User;
use Rendes\Modules\Courses\Interfaces as Interfaces;

class QuizStartValidator extends CourseBaseService implements IQuizStartValidator
{

	/**
	 * @var Interfaces\ResultRepositories\IQuizResultRepository
	 */
	private $repository = null;

	public function init(){}

	public function validate(Quiz $quiz, User $user)
	{

		$attemptsCount = $this->getResultRepository()->getAttemptCount($quiz, $user);
		$quizOptions = $quiz->getOptions();
		if(isset($quizOptions['attempts']) && $quizOptions['attempts'] <= $attemptsCount){
			return false;
		}

		return true;
	}

	/**
	 * @return Interfaces\ResultRepositories\IQuizResultRepository
	 */
	public function getResultRepository()
	{
		if(is_null($this->repository)){
			$this->repository = $this->loadResultRepository('quiz');
		}
		return $this->repository;
	}



}