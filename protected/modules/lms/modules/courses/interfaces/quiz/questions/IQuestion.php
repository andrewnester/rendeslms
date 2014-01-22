<?php

namespace Rendes\Modules\Courses\Interfaces\Quiz\Questions;

interface IQuestion
{
    public function getQuestion();
    public function getAnswers();

    public function getConfiguration();

    public function getResult($proposedAnswers);
}
