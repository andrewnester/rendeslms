<?php

namespace Rendes\Modules\Courses\Entities\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quiz
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\Courses\Repositories\QuizRepository")
 * @ORM\Table(name="quiz")
 * @ORM\HasLifecycleCallbacks
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"countanswered"="CountAnsweredQuiz", "pointsreceived" = "PointsReceivedQuiz"})
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
	 * @ORM\OneToMany(targetEntity="\Rendes\Modules\Courses\Entities\Quiz\Questions\Question", mappedBy="quiz")
	 * @ORM\OrderBy({"order" = "ASC"})
	 */
	private $questions;

    /**
     * @var array
     *
     * @ORM\Column(name="widget", type="array", nullable=false)
     */
    private $widget;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="order_position", type="integer", nullable=false)
	 */
	private $order;

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
	 * @return mixed
	 */
	public function getType()
	{
		if (preg_match('@\\\\([\w]+)$@', get_called_class(), $matches)) {
			$classname = $matches[1];
		}
		return $classname;
	}


    /**
     * @return array
     */
    public function rules(){
        return array(
            array('name, description, widget', 'required'),
        );
    }


	public function attributeNames()
	{
		return array(
			'name', 'description', 'widgets'
		);
	}


	/**
	 * @return array
	 */
	public function getOptions()
	{
		$widget = array_shift(array_values($this->getWidget()));
		return $widget['options'];
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
    public function onPersist()
    {
		$this->order = 0;
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

	/**
	 * @param int $order
	 */
	public function setOrder($order)
	{
		$this->order = $order;
	}

	/**
	 * @return int
	 */
	public function getOrder()
	{
		return $this->order;
	}



	public function getQuizTypeDescription()
	{

	}

}