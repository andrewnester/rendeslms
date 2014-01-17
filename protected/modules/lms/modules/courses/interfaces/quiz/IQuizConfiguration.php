<?php

interface IQuizConfiguration
{
    /**
     * @return IQuizCalculator
     */
    public function getCalculator();

    /**
     * @return IQuizWidget
     */
    public function getWidget();

}