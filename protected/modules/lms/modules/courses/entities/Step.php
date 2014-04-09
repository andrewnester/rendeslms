<?php

namespace Rendes\Modules\Courses\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Step
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\Courses\Repositories\StepRepository")
 * @ORM\Table(name="step")
 * @ORM\HasLifecycleCallbacks
 */
class Step extends \CFormModel
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
     * @var \Rendes\Modules\Courses\Entities\Course
     *
     * @ORM\ManyToOne(targetEntity="\Rendes\Modules\Courses\Entities\Course")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;

    /**
     * @var \Rendes\Modules\Courses\Entities\Lecture\Lecture
     *
     * @ORM\OneToMany(targetEntity="\Rendes\Modules\Courses\Entities\Lecture\Lecture", mappedBy="step")
     * @ORM\OrderBy({"order" = "ASC"})
     */
    private $lectures;

    /**
     * @var \Rendes\Modules\Courses\Entities\Quiz\Quiz
     *
     * @ORM\OneToMany(targetEntity="\Rendes\Modules\Courses\Entities\Quiz\Quiz", mappedBy="step")
	 * @ORM\OrderBy({"order" = "ASC"})
     */
    private $quizzes;

    /**
     * @var Array
     *
     * @ORM\Column(name="path", type="array")
     */
    private $path;

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
        $this->requiredSteps = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function rules(){
        return array(
            array('name, description', 'required'),
        );
    }




    /**
     * @param \Rendes\Modules\Courses\Entities\Course $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
    }

    /**
     * @return \Rendes\Modules\Courses\Entities\Course
     */
    public function getCourse()
    {
        return $this->course;
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
     * @param \Rendes\Modules\Courses\Entities\Lecture\Lecture $lectures
     */
    public function setLectures($lectures)
    {
        $this->lectures = $lectures;
    }

    /**
     * @return \Rendes\Modules\Courses\Entities\Lecture\Lecture
     */
    public function getLectures()
    {
        return $this->lectures;
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
     * @param Array $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return Array
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param \Rendes\Modules\Courses\Entities\Quiz\Quiz $quizzes
     */
    public function setQuizzes($quizzes)
    {
        $this->quizzes = $quizzes;
    }

    /**
     * @return \Rendes\Modules\Courses\Entities\Quiz\Quiz
     */
    public function getQuizzes()
    {
        return $this->quizzes;
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