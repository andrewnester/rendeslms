<?php

namespace Rendes\Modules\Courses\Services\Quiz\Validators;

use Rendes\Modules\Courses\Interfaces\Quiz\IQuizStartValidator;
use Rendes\Modules\Courses\Entities\Quiz\Quiz;
use Rendes\Modules\Courses\Services\CourseBaseService;
use Rendes\Modules\User\Entities\User;
use Rendes\Modules\Courses\Interfaces as Interfaces;

class PointsReceivedQuizValidator extends CourseBaseService implements IQuizStartValidator
{
	public function validate(Quiz $quiz, User $user)
	{
		$points = 0;
		$attempts = $this->getResultRepository()->getAttempts($quiz, $user);
		$quizQuestions = $quiz->getQuestions();

		foreach($attempts as $attempt){
			$sessionID = $attempt->context->registration;
			$rightAnswered = $this->getResultRepository()->getRightAnsweredQuestions($quiz, $user, $sessionID);

			foreach($rightAnswered as $rightAnsweredQuestion){
				foreach($quizQuestions as $question){
					$activityID = \Yii::app()->createUrl('/lms/courses/questions', array(
						'courseID' => $quiz->getStep()->getCourse()->getID(),
						'stepID' => $quiz->getStep()->getId(),
						'quizID' => $quiz->getId(),
						'id' => $question->getId()));

					if($rightAnsweredQuestion->object->id == $activityID){
						$points += $question->getPoints();
					}
				}
			}
		}
		return $points;
	}

	/**
	 * @return Interfaces\ResultRepositories\IQuizResultRepository
	 */
	public function getResultRepository()
	{
		return $this->loadResultRepository('quiz');
	}
}