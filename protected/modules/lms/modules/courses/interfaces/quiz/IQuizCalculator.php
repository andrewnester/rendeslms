<?php
/**
 * User: nester_a
 * Date: 17.01.14
 */

interface IQuizCalculator
{
    /**
     * @param IQuestion[] $questions
     */
    public function calculate($questions);
}