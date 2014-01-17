<?php

abstract class Question implements IQuestion
{
    protected $weight;
    protected $answers;
    protected $question;

    /**
     * @var IQuestionConfiguration
     */
    protected $configuration;

    public function getResult($proposedAnswers)
    {
        $calculator = $this->configuration->getCalculator();
        return $calculator->calculate($this->answers, $proposedAnswers);
    }
}