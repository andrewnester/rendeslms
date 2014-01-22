<?php
/**
 * User: nester_a
 * Date: 17.01.14
 */

namespace Rendes\Modules\Courses\Interfaces\Quiz;

interface IQuizCalculator
{
    /**
     * @param IQuestion[] $questions
     */
    public function calculate($questions);
}