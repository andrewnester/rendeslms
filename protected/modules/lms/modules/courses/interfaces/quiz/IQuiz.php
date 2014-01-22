<?php

namespace Rendes\Modules\Courses\Interfaces\Quiz;

interface IQuiz
{
    public function getName();
    /**
     * @return IQuizConfiguration
     */
    public function getConfiguration();

}



