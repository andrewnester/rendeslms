<?php
/**
 * User: nester_a
 * Date: 17.01.14
 */

namespace Rendes\Modules\Courses\Entities\Quiz\Questions\Validators;

class PercentFromMaxQuestionValidator implements \Rendes\Modules\Courses\Interfaces\Quiz\Questions\IQuestionValidator
{
    public function validate($answers, $proposedAnswers)
    {
        $rightAnswers = array_intersect($answers, $proposedAnswers);
        return count($rightAnswers)/count($answers);
    }
}
