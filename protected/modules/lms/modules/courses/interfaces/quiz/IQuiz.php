<?php

interface IQuiz
{
    public function getName();
    /**
     * @return IQuizConfiguration
     */
    public function getConfiguration();

}



