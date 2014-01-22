<?php

namespace Rendes\Modules\Courses\Interfaces\Quiz\Questions;

interface IQuestionConfiguration
{
    /**
     * @return IQuestionCalculator
     */
    public function getCalculator();

    /**
     * @return IQuestionWidget
     */
    public function getWidget();

    /**
     * @param IQuestionCalculator $calculator
     */
    public function setCalculator(IQuestionCalculator $calculator);

    /**
     * @param IQuestionWidget $widget
     */
    public function setWidget(IQuestionWidget $widget);
}