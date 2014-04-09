<?php

namespace Rendes\Modules\Courses\Entities\Quiz\Questions;

use Doctrine\ORM\Mapping as ORM;
use Rendes\Modules\Courses\Services\QuestionService;

/**
 * Question
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\Courses\Repositories\QuestionRepository")
 * @ORM\Table(name="question")
 * @ORM\InheritanceType("JOINED")
 * @ORM\HasLifecycleCallbacks
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"question"="Question", "variantquestion" = "VariantQuestion"})
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
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    protected $title;

	/**
	 * @var \Rendes\Modules\Courses\Entities\Quiz\Quiz
	 *
	 * @ORM\ManyToOne(targetEntity="\Rendes\Modules\Courses\Entities\Quiz\Quiz")
	 * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
	 */
	protected $quiz;

    /**
     * @var Array
     *
     * @ORM\Column(name="answers", type="array", length=255, nullable=false)
     */
    protected $answers;

    /**
     * @var array
     *
     * @ORM\Column(name="calculator", type="array", nullable=false)
     */
    protected $validator;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="order_position", type="integer", nullable=false)
	 */
	protected $order;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255, nullable=false)
     */
    protected $question;



	/**
	 * @return array
	 */
	public function rules(){
		return array(
			array('title, question, answers', 'required'),
			array('answers','type','type'=>'array','allowEmpty'=>false),
		);
	}


	public function attributeNames()
	{
		return array(
			'title', 'question', 'answers'
		);
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

    public function getType()
    {
		if (preg_match('@\\\\([\w]+)$@', get_called_class(), $matches)) {
			$classname = $matches[1];
		}
		return $classname;
    }


	public function getTypeDescription()
	{
		$questionService = new \Rendes\Modules\Courses\Services\QuestionService();
		$types = $questionService->getAvailableTypes();
		$calledClass = get_called_class();
		foreach($types as $className => $name){
			if($className == '\\'.$calledClass){
				return $name;
			}
		}
		return 'Question';
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
     * @param Array $answers
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
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

    /**
     * @param array $calculator
     */
    public function setValidator($calculator)
    {
        $this->validator = $calculator;
    }

    /**
     * @return array
     */
    public function getValidator()
    {
        return $this->validator;
    }

    public function getValidatorObject()
    {
        return new \Rendes\Modules\Courses\Entities\Quiz\Questions\Validators\SimpleQuestionValidator();
    }

    /**
     * @return array
     */
    public function getWidget()
    {
        $questionService = new \Rendes\Modules\Courses\Services\QuestionService();
        return $questionService->getWidgetByClassName(get_called_class());
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

	/**
	 * @param \Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz
	 */
	public function setQuiz($quiz)
	{
		$this->quiz = $quiz;
	}

	/**
	 * @return \Rendes\Modules\Courses\Entities\Quiz\Quiz
	 */
	public function getQuiz()
	{
		return $this->quiz;
	}


	/** @ORM\PrePersist */
	public function onPersist()
	{
		$this->order = 0;
	}

}