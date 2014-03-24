<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Modules\Courses\Repositories\ResultRepositories\XAPI;
use \Rendes\Modules\Courses\Interfaces\ResultRepositories as ResultRepositories;

class QuizResultRepository extends BaseResultRepository implements ResultRepositories\IQuizResultRepository
{
    public function findQuizQuestionResult(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz)
    {

    }

    public function getAttemptCount(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user)
    {
        $xapi = $this->getXAPI();
        $searchOptions = array(
            'agent' => json_encode(array(
                'mbox' => $user->getEmail()
            )),
            'verb' => 'http://adlnet.gov/expapi/verbs/attempted' ,
            'activity' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$quiz->getStep()->getCourse()->getId().'/steps/'.$quiz->getStep()->getId().'/quizzes/'.$quiz->getId()),
            'related_activities' => true
        );
        $statements = $xapi->getStatements($searchOptions);
        return is_array($statements) ? count($statements) : 1;
    }

}