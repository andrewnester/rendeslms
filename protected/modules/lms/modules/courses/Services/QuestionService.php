<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Entities\Quiz as Quiz;
use \Rendes\Modules\Courses\Entities\Quiz\Questions as Questions;
use \Rendes\Modules\Courses\Interfaces as Interfaces;

class QuestionService extends CourseBaseService
{

    /**
     * @var Interfaces\ResultRepositories\IQuestionResultRepository
     */
    private $repository = null;

    /**
     * @return Interfaces\ResultRepositories\IQuestionResultRepository
     */
    public function getResultRepository()
    {
        if(is_null($this->repository)){
            $this->repository = $this->loadResultRepository('question');
        }
        return $this->repository;
    }

    public function populateQuestion(Questions\Question $question, $questionData)
    {
        $question->setTitle($questionData['title']);
        $question->setQuestion($questionData['question']);
        $question->setWeight($questionData['weight']);
        $question->setAnswers($questionData['answers']);

        return $question;
    }

    public function populateVariantQuestion(Questions\VariantQuestion $question, $questionData)
    {
        $question = $this->populateQuestion($question, $questionData);
        $question->setVariants($questionData['variants']);

        return $question;
    }

    public function getWidgetByClassName($classname)
    {
        $widgetPath = \Yii::app()->getModule('lms')->params->namespaces['questions']['widgets'];
        $widgetClass = $widgetPath . '\\' . $this->getClassName($classname);
        return new $widgetClass();
    }

	public function prepareQuestionResultStatement(Questions\Question $question, \Rendes\Modules\User\Entities\User $user, $sessionID, $validationResult, $courseID, $stepID, $quizID)
    {
        return array(
            'actor' => array(
                'mbox' => $user->getEmail()
            ),
            'verb' => array(
                'id' => 'http://adlnet.gov/expapi/verbs/answered'
            ),
            'object' => array(
                'id' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$courseID.'/steps/'.$stepID.'/quizzes/'.$quizID.'/questions/'.$question->getId()),
				'objectType' => 'Activity',
                'definition' => array(
                    'name' => array(
                        'en-US' => $question->getTitle()
                    ),
                    'description' => array(
                        'en-US' => $question->getQuestion()
                    ),
                )
            ),
            'result' => array(
                'success' => $validationResult
            ),
            'context' => array(
				'registration' => $sessionID,
                'contextActivities' => array(
                    'grouping' => array(
						'registration' => $sessionID,
                        'id' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$courseID.'/steps/'.$stepID.'/quizzes/'.$quizID),
                    )
                )
            )
        );
    }

	public function isAnsweredQuestion(\Rendes\Modules\Courses\Entities\Quiz\Questions\Question $question, \Rendes\Modules\User\Entities\User $user, $sessionID)
	{
		$searchOptions = array(
			'agent' => json_encode(array(
				'mbox' => $user->getEmail()
			)),
			'verb' => 'http://adlnet.gov/expapi/verbs/answered',
			'activity' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$question->getQuiz()->getStep()->getCourse()->getId().'/steps/'.$question->getQuiz()->getStep()->getId().'/quizzes/'.$question->getQuiz()->getId(). '/questions/'.$question->getId()),
			'registration' => $sessionID
		);
		$statements = $this->getXAPI()->getStatements($searchOptions);
		return $statements !== false && !empty($statements);
	}

    public function getAvailableTypes()
    {
        return array(
            'Question' => 'Simple Question',
            'VariantQuestion' => 'Question with variants'
        );
    }


}