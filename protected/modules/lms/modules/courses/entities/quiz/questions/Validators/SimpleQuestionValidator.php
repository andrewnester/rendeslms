<?php
/**
 * User: nester_a
 * Date: 17.01.14
 */

namespace Rendes\Modules\Courses\Entities\Quiz\Questions\Validators;

class SimpleQuestionValidator implements \Rendes\Modules\Courses\Interfaces\Quiz\Questions\IQuestionValidator
{
    public function validate($answers, $proposedAnswers)
    {
        $proposedAnswers = is_array($proposedAnswers) ? $proposedAnswers : array($proposedAnswers);
        foreach($answers as $answer){
            if(!in_array($answer, $proposedAnswers)){
                return false;
            }
        }
        return true;
}
}
