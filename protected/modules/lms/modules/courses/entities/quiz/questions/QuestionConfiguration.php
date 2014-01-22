<?php

namespace Rendes\Modules\Courses\Entities\Quiz\Questions;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionConfiguration
 *
 * @ORM\Entity
 * @ORM\Table(name="question_configuration")
 */
class QuestionConfiguration extends \CFormModel  implements \Rendes\Modules\Courses\Interfaces\Quiz\Questions\IQuestionConfiguration
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
    public $calculator;

    /**
     * @var string
     *
     * @ORM\Column(name="widget", type="string", length=255, nullable=false)
     */
    public $widget;



    public function getCalculator()
    {
        // TODO: Implement getCalculator() method.
    }

    public function getWidget()
    {
        // TODO: Implement getWidget() method.
    }

    public function setCalculator(\Rendes\Modules\Courses\Interfaces\Quiz\Questions\IQuestionCalculator $calculator)
    {
        // TODO: Implement setCalculator() method.
    }

    public function setWidget(\Rendes\Modules\Courses\Interfaces\Quiz\Questions\IQuestionWidget $widget)
    {
        // TODO: Implement setWidget() method.
    }


}