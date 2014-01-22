<?php
/**
 * User: nester_a
 * Date: 17.01.14
 */

namespace Rendes\Modules\Courses\Entities\Quiz\Questions\Calculators;

class PercentFromMaxQuestionCalculator implements \Rendes\Modules\Courses\Interfaces\Quiz\Questions\IQuestionCalculator
{
    public function calculate($answers, $proposedAnswers)
    {
        $rightAnswers = array_intersect($answers, $proposedAnswers);
        return count($rightAnswers)/count($answers);
    }
}
