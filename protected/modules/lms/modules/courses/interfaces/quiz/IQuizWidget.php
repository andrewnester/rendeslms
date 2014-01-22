<?php

namespace Rendes\Modules\Courses\Interfaces\Quiz;

// COULD BE YII WIDGET!!!
interface IQuizWidget
{
    public function render(IQuiz $quiz);
}