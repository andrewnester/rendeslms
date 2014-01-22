<?php

namespace Rendes\Modules\Courses\Entities\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quiz
 *
 * @ORM\Entity
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
    public $step;


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
     * @var \Rendes\Modules\Courses\Entities\Quiz\Questions\Question
     *
     * @ORM\OneToMany(targetEntity="\Rendes\Modules\Courses\Entities\Quiz\Questions\Question", mappedBy="quiz")
     */
    protected $questions;


    /**
     * @var QuizConfiguration
     *
     * @ORM\OneToOne(targetEntity="QuizConfiguration")
     * @ORM\JoinColumn(name="configuration_id", referencedColumnName="id")
     */
    protected $configuration;


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



}