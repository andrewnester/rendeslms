<?php

interface IQuestion
{
    public function getQuestion();
    public function getAnswers();

    public function getConfiguration();

    public function getResult($proposedAnswers);
}
