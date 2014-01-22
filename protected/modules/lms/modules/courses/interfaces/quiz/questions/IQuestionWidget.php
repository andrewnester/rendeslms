<?php

namespace Rendes\Modules\Courses\Interfaces\Quiz\Questions;

// COULD BE YII WIDGET!!!
interface IQuestionWidget
{
    public function render(IQuestion $question);
}