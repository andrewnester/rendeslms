<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 17.11.13
 * Time: 16:06
 * To change this template use File | Settings | File Templates.
 */

namespace Rendes\Modules\User\Modules\Marks\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mark
 *
 * @ORM\Table(name="mark")
 * @ORM\Entity(repositoryClass="\Rendes\Modules\User\Modules\Marks\Repositories\MarkRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Mark extends \CFormModel
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
     * @var \Rendes\Modules\Courses\Entities\Step
     *
	 * @ORM\ManyToOne(targetEntity="\Rendes\Modules\Courses\Entities\Step")
	 * @ORM\JoinColumn(name="step_id", referencedColumnName="id")
     */
    private $step;

	/**
	 * @var \Rendes\Modules\User\Entities\Student
	 *
	 * @ORM\ManyToOne(targetEntity="\Rendes\Modules\User\Entities\Student")
	 * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
	 */
	private $student;

	/**
	 * @var \Rendes\Modules\User\Entities\Teacher
	 *
	 * @ORM\ManyToOne(targetEntity="\Rendes\Modules\User\Entities\Teacher")
	 * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id")
	 */
	private $teacher;

    /**
     * @var int
     *
     * @ORM\Column(name="mark", type="integer", nullable=false)
     */
    private $mark;

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

    }


    public function rules(){
        return array(
            array('mark', 'required'),
        );
    }

    public function attributeNames()
    {
        return array(
            'id'=>'id',
            'mark'=>'mark',
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
	 * @param int $mark
	 */
	public function setMark($mark)
	{
		$this->mark = $mark;
	}

	/**
	 * @return int
	 */
	public function getMark()
	{
		return $this->mark;
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
	 * @param \Rendes\Modules\User\Entities\Student $student
	 */
	public function setStudent($student)
	{
		$this->student = $student;
	}

	/**
	 * @return \Rendes\Modules\User\Entities\Student
	 */
	public function getStudent()
	{
		return $this->student;
	}

	/**
	 * @param \Rendes\Modules\User\Entities\Teacher $teacher
	 */
	public function setTeacher($teacher)
	{
		$this->teacher = $teacher;
	}

	/**
	 * @return \Rendes\Modules\User\Entities\Teacher
	 */
	public function getTeacher()
	{
		return $this->teacher;
	}

}