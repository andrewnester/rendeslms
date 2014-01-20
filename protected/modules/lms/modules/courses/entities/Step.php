<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Step
 *
 * @ORM\Entity
 * @ORM\Table(name="step")
 * @ORM\HasLifecycleCallbacks
 */
class Step extends CFormModel
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
     * @var Course
     *
     * @ORM\ManyToOne(targetEntity="Course")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;

    /**
     * @var Lecture
     *
     * @ORM\OneToMany(targetEntity="Lecture", mappedBy="step")
     */
    private $lectures;

    /**
     * @var Quiz
     *
     * @ORM\OneToMany(targetEntity="Quiz", mappedBy="step")
     */
    private $quizzes;

    /**
     * @var Array
     *
     * @ORM\Column(name="path", type="array")
     */
    private $path;

    /**
     * @var Array
     *
     * @ORM\Column(name="required_steps", type="simple_array")
     */
    private $requiredSteps;

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