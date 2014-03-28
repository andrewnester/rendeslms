<?php

namespace Rendes\Modules\Courses\Interfaces\Quiz;

interface IQuiz
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return \Rendes\Modules\Courses\Entities\Step
     */
    public function getStep();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getDescription();
    public function getQuestions();
}



