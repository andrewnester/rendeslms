<?php

namespace Rendes\Modules\Courses\Entities\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quiz
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\Courses\Repositories\QuizRepository")
 * @ORM\Table(name="quiz")
 * @ORM\HasLifecycleCallbacks
 */
class Quiz extends \CFormModel implements \Rendes\Modules\Courses\Interfaces\Quiz\IQuiz
{

    /**
     * @var \Rendes\Modules\Courses\Entities\Step
     *
     * @ORM\ManyToOne(targetEntity="\Rendes\Modules\Courses\Entities\Step")
     * @ORM\JoinColumn(name="step_id", referencedColumnName="id")
     */
    private $step;

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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var \Rendes\Modules\Courses\Entities\Quiz\Questions\Question
     *
     * @ORM\ManyToMany(targetEntity="\Rendes\Modules\Courses\Entities\Quiz\Questions\Question")
     * @ORM\JoinTable(name="User_Group",
     *      joinColumns={@ORM\JoinColumn(name="quiz_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="question_id", referencedColumnName="id")}
     *      )
     */
    private $questions;

    /**
     * @var QuizConfiguration
     *
     * @ORM\OneToOne(targetEntity="QuizConfiguration")
     * @ORM\JoinColumn(name="configuration_id", referencedColumnName="id")
     */
    private $configuration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated;




    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
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
     * @param \Rendes\Modules\Courses\Entities\Quiz\Questions\Question $questions
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }

    /**
     * @return \Rendes\Modules\Courses\Entities\Quiz\Questions\Question
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param \Rendes\Modules\Courses\Entities\Step $step
     */
    public function setStep($step)
    {
        $this->step = $step;
    }

    /**
     * @return \Rendes\Modules\Courses\Entities\Step
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param \Rendes\Modules\Courses\Entities\Quiz\QuizConfiguration $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \Rendes\Modules\Courses\Interfaces\Quiz\IQuizConfiguration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /** @ORM\PrePersist */
    public function setCreationDate()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /** @ORM\PreUpdate */
    public function setUpdatedDate()
    {
        $this->updated = new \DateTime();
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }





}