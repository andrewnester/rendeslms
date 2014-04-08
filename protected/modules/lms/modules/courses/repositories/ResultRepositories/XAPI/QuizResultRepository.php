<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Modules\Courses\Repositories\ResultRepositories\XAPI;
use \Rendes\Modules\Courses\Interfaces\ResultRepositories as ResultRepositories;

class QuizResultRepository extends BaseResultRepository implements ResultRepositories\IQuizResultRepository
{
    public function getAttemptCount(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user)
    {
        $statements = $this->getAttempts($quiz, $user);
        return is_array($statements) ? count($statements) : 1;
    }

	public function getAnsweredQuestions(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user, $sessionID)
	{
		$searchOptions = array(
			'agent' => json_encode(array(
				'mbox' => $user->getEmail()
			)),
			'verb' => 'http://adlnet.gov/expapi/verbs/answered',
			'activity' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$quiz->getStep()->getCourse()->getId().'/steps/'.$quiz->getStep()->getId().'/quizzes/'.$quiz->getId()),
			'related_activities' => true,
			'registration' => $sessionID
		);
		return $this->getXAPI()->getStatements($searchOptions);
	}

	public function getRightAnsweredQuestions(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user, $sessionID)
	{
		$answers = $this->getAnsweredQuestions($quiz, $user, $sessionID);
		$rightAnswers = array();
		foreach($answers as $answer){
			if($answer->result->success == true){
				$rightAnswers[] = $answer;
			}
		}

		return $rightAnswers;
	}

	public function getAttempts(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user)
	{
		$searchOptions = array(
			'agent' => json_encode(array(
				'mbox' => $user->getEmail()
			)),
			'verb' => 'http://adlnet.gov/expapi/verbs/attempted',
			'activity' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$quiz->getStep()->getCourse()->getId().'/steps/'.$quiz->getStep()->getId().'/quizzes/'.$quiz->getId()),
			'related_activities' => true,
		);
		return $this->getXAPI()->getStatements($searchOptions);
	}

}