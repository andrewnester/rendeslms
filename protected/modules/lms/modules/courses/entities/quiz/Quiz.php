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
     * @ORM\JoinTable(name="quiz_questions",
     *      joinColumns={@ORM\JoinColumn(name="quiz_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="question_id", referencedColumnName="id")}
     *      )
     */
    private $questions;

    /**
     * @var array
     *
     * @ORM\Column(name="passing_rule", type="array", nullable=false)
     */
    private $passingRule;

    /**
     * @var array
     *
     * @ORM\Column(name="widget", type="array", nullable=false)
     */
    private $widget;

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




    public function __construct()
    {
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * @return bool
     */
    public function isPassed()
    {

    }

    /**
     * @return bool
     */
    public function isStarted()
    {

    }


    /**
     * @return array
     */
    public function rules(){
        return array(
            array('name, description, passingRule, widget', 'required'),
        );
    }



    /**
     * @param array $widget
     */
    public function setWidget($widget)
    {
        $this->widget = $widget;
    }

    /**
     * @return array
     */
    public function getWidget()
    {
        if(empty($this->widget)){
            return array();
        }

        return $this->widget;
    }

    /**
     * @return mixed
     */
    public function getWidgetObject()
    {
        $widget = array_shift(array_values($this->widget));
        return new $widget['classname']($widget['options']);
    }

    /**
     * @param string $passingRule
     */
    public function setPassingRule($passingRule)
    {
        $this->passingRule = $passingRule;
    }

    /**
     * @return array
     */
    public function getPassingRule()
    {
        if(empty($this->passingRule)){
            return array();
        }

        return $this->passingRule;
    }

    /**
     * @return \Rendes\Modules\Courses\Interfaces\Quiz\IQuizRule
     */
    public function getPassingRuleObject()
    {
        $rule = array_shift(array_values($this->passingRule));
        return new $rule['classname']($rule['options']);
    }

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
     * @return \Doctrine\Common\Collections\ArrayCollection
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
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