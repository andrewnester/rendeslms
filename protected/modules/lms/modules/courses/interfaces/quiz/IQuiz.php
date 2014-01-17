<?php

interface IQuiz
{
    public function getName();
    public function getType();

    /**
     * @return IQuizConfiguration
     */
    public function getConfiguration();

}



