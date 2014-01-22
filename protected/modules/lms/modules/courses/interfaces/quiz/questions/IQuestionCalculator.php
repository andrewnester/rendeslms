<?php

namespace Rendes\Modules\Courses\Interfaces\Quiz\Questions;

interface IQuestionCalculator
{
    public function calculate($answers, $proposedAnswers);
}