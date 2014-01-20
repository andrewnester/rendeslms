<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * QuizConfiguration
 *
 * @ORM\Entity
 * @ORM\Table(name="quiz_configuration")
 */
class QuizConfiguration extends CFormModel implements IQuizConfiguration
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="calculator", type="string", length=255, nullable=false)
     */
    private $calculator;

    /**
     * @var string
     *
     * @ORM\Column(name="widget", type="string", length=255, nullable=false)
     */
    private $widget;


    /**
     * @return IQuizCalculator
     */
    public function getCalculator()
    {
        // TODO: Implement getCalculator() method.
    }

    /**
     * @return IQuizWidget
     */
    public function getWidget()
    {
        // TODO: Implement getWidget() method.
    }

    /**
     * @param IQuizCalculator $calculator
     */
    public function setCalculator(IQuizCalculator $calculator)
    {
        // TODO: Implement setCalculator() method.
    }

    /**
     * @param IQuizWidget $widget
     */
    public function setWidget(IQuizWidget $widget)
    {
        // TODO: Implement setWidget() method.
    }

}