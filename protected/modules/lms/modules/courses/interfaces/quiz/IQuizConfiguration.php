<?php

namespace Rendes\Modules\Courses\Interfaces\Quiz;

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