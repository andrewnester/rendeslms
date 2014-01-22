<?php

namespace Rendes\Modules\Courses\Entities\Quiz\Questions;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Entity
 * @ORM\Table(name="question")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"variant" = "VariantQuestion"})
 */
abstract class Question implements \Rendes\Modules\Courses\Interfaces\Quiz\Questions\IQuestion
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
     * @var float
     *
     * @ORM\Column(name="weight", type="float", length=255, nullable=false)
     */
    protected $weight;

    /**
     * @var Array
     *
     * @ORM\Column(name="answers", type="array", length=255, nullable=false)
     */
    protected $answers;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255, nullable=false)
     */
    protected $question;

    /**
     * @var \Rendes\Modules\Courses\Interfaces\Quiz\Questions\IQuestionConfiguration
     */
    protected $configuration;

    public function getResult($proposedAnswers)
    {
        $calculator = $this->configuration->getCalculator();
        return $calculator->calculate($this->answers, $proposedAnswers);
    }
}