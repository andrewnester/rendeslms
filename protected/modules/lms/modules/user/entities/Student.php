<?php

namespace Rendes\Modules\User\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\User\Repositories\StudentRepository")
 */
class Student extends User
{

	/**
	 * @var string
	 *
	 * @ORM\Column(name="fio", type="string", length=255, nullable=false)
	 */
	private $fio;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="age", type="integer", nullable=false)
	 */
	private $age;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="number", type="string", length=255, nullable=false)
	 */
	private $studentNumber;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="place", type="string", length=255, nullable=false)
	 */
	private $place;

	/**
	 * @var \Rendes\Modules\Groups\Entities\Group
	 *
	 * @ORM\ManyToOne(targetEntity="\Rendes\Modules\Groups\Entities\Group")
	 * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
	 */
	private $group;

	function __construct()
	{
		$this->setRole('student');
	}

	public function rules()
	{
		$rules = parent::rules();
		$rules[] = array('fio, age, studentNumber, place', 'required');
		$rules[] = array('age', 'numerical');
		return $rules;
	}

	/**
	 * @param string $age
	 */
	public function setAge($age)
	{
		$this->age = $age;
	}

	/**
	 * @return string
	 */
	public function getAge()
	{
		return $this->age;
	}

	/**
	 * @param string $fio
	 */
	public function setFio($fio)
	{
		$this->fio = $fio;
	}

	/**
	 * @return string
	 */
	public function getFio()
	{
		return $this->fio;
	}

	/**
	 * @param string $place
	 */
	public function setPlace($place)
	{
		$this->place = $place;
	}

	/**
	 * @return string
	 */
	public function getPlace()
	{
		return $this->place;
	}

	/**
	 * @param string $studentNumber
	 */
	public function setStudentNumber($studentNumber)
	{
		$this->studentNumber = $studentNumber;
	}

	/**
	 * @return string
	 */
	public function getStudentNumber()
	{
		return $this->studentNumber;
	}

	/**
	 * @param \Rendes\Modules\Groups\Entities\Group $group
	 */
	public function setGroup($group)
	{
		$this->group = $group;
	}

	/**
	 * @return \Rendes\Modules\Groups\Entities\Group
	 */
	public function getGroup()
	{
		return $this->group;
	}


}
