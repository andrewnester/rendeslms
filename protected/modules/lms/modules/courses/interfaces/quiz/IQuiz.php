<?php

namespace Rendes\Modules\Courses\Interfaces\Quiz;

interface IQuiz
{
    public function getName();
    public function getDescription();
    public function getPassingRuleObject();
    public function getQuestions();
}



