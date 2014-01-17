<?php

interface IQuestionCalculator
{
    public function calculate($answers, $proposedAnswers);
}