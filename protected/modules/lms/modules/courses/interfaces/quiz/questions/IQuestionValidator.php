<?php

namespace Rendes\Modules\Courses\Interfaces\Quiz\Questions;

interface IQuestionValidator
{
    public function validate($answers, $proposedAnswers);
}