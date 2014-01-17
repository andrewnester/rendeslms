<?php
/**
 * User: nester_a
 * Date: 17.01.14
 */

class PercentFromMaxQuestionCalculator implements IQuestionCalculator
{
    public function calculate($answers, $proposedAnswers)
    {
        $rightAnswers = array_intersect($answers, $proposedAnswers);
        return count($rightAnswers)/count($answers);
    }
}
