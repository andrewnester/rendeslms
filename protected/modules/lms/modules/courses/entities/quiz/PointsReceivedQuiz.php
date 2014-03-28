<?php

namespace Rendes\Modules\Courses\Entities\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * PointsReceivedQuiz
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\Courses\Repositories\QuizRepository")
 */
class PointsReceivedQuiz extends Quiz
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="points", type="integer", nullable=false)
	 */
	private $points;

	/**
	 * @param int $points
	 */
	public function setPoints($points)
	{
		$this->points = $points;
	}

	/**
	 * @return int
	 */
	public function getPoints()
	{
		return $this->points;
	}


	public function rules()
	{
		$rules = parent::rules();
		$rules[] = array('points', 'required');
		$rules[] = array('points', 'numerical');
		return $rules;
	}

	public function attributeNames()
	{
		$attributes = parent::attributeNames();
		$attributes[] = 'points';
		return $attributes;
	}

}