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
 * @ORM\DiscriminatorMap({"question"="Question", "variant" = "VariantQuestion"})
 */
class Question extends \CFormModel implements \Rendes\Modules\Courses\Interfaces\Quiz\Questions\IQuestion
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
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    protected $title;

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

    /**
     * @return Array
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    public function getConfiguration()
    {
        // TODO: Implement getConfiguration() method.
    }

    public function getType()
    {
        $questionService = new \Rendes\Modules\Courses\Services\QuestionService();
        $types = $questionService->getAvailableTypes();
        if (preg_match('@\\\\([\w]+)$@', get_called_class(), $matches)) {
            $classname = $matches[1];
        }
        return $types[$classname];
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param Array $answers
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
    }

    /**
     * @param \Rendes\Modules\Courses\Interfaces\Quiz\Questions\IQuestionConfiguration $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }





}