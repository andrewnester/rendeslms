<?php

namespace Rendes\Modules\User\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teacher
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\User\Repositories\TeacherRepository")
 */
class Teacher extends User
{
	/**
	 * @var \Rendes\Modules\Courses\Entities\Course
	 *
	 * @ORM\ManyToMany(targetEntity="\Rendes\Modules\Courses\Entities\Course", mappedBy="teachers")
	 */
	private $courses;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="degree", type="string", length=255, nullable=false)
	 */
	private $degree;


	function __construct()
	{
		$this->setRole('teacher');
		$this->courses = new \Doctrine\Common\Collections\ArrayCollection();
	}


	public function rules()
	{
		$rules = parent::rules();
		$rules[] = array('degree', 'required');
		return $rules;
	}

	public function attributeNames()
	{
		$attributes = parent::attributeNames();
		$attributes[] = 'password';
		$attributes[] = 'degree';
		return $attributes;
	}


	/**
	 * @return mixed
	 */
	public function getCourses()
	{
		return $this->courses;
	}

	/**
	 * @param string $degree
	 */
	public function setDegree($degree)
	{
		$this->degree = $degree;
	}

	/**
	 * @return string
	 */
	public function getDegree()
	{
		return $this->degree;
	}

}
