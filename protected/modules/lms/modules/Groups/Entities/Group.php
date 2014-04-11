<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 17.11.13
 * Time: 16:06
 * To change this template use File | Settings | File Templates.
 */

namespace Rendes\Modules\Groups\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 *
 * @ORM\Table(name="study_group")
 * @ORM\Entity(repositoryClass="\Rendes\Modules\Groups\Repositories\GroupRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Group extends \CFormModel
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
     * @var \Rendes\Modules\Courses\Entities\Course
     *
     * @ORM\ManyToMany(targetEntity="\Rendes\Modules\Courses\Entities\Course")
	 * @ORM\JoinTable(name="Group_Course",
	 *      joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")}
	 *      )
     */
    private $courses;

	/**
	 * @var \Rendes\Modules\User\Entities\Student
	 *
	 * @ORM\OneToMany(targetEntity="\Rendes\Modules\User\Entities\Student", mappedBy="group")
	 * @ORM\OrderBy({"name" = "ASC"})
	 */
	private $students;

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
	 * @var boolean
	 *
	 * @ORM\Column(name="is_public", type="boolean", nullable=false)
	 */
	private $isPublic;

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
		$this->courses = new \Doctrine\Common\Collections\ArrayCollection();
		$this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function rules(){
        return array(
            array('name, description', 'required'),
        );
    }

    public function attributeNames()
    {
        return array(
            'id'=>'id',
            'name'=>'name',
            'description'=>'description',
            'created'=>'created',
            'updated'=>'updated'
        );
    }

    public function attributeLabels()
    {
        return array(
            'created' => 'Create Date',
            'updated' => 'Update Date',
        );
    }



    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return string
     */
    public function getCreatedString()
    {
        return $this->created->format('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function getUpdatedString()
    {
        return $this->updated->format('Y-m-d H:i:s');
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
     * @param \Step $steps
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;
    }

    /**
     * @return \Step
     */
    public function getSteps()
    {
        return $this->steps;
    }

	/**
	 * @param \Rendes\Modules\User\Entities\Student $students
	 */
	public function setStudents($students)
	{
		$this->students = $students;
	}

	/**
	 * @return \Rendes\Modules\User\Entities\Student
	 */
	public function getStudents()
	{
		return $this->students;
	}

	/**
	 * @param boolean $isPublic
	 */
	public function setIsPublic($isPublic)
	{
		$this->isPublic = $isPublic;
	}

	/**
	 * @return boolean
	 */
	public function getIsPublic()
	{
		return $this->isPublic;
	}


}