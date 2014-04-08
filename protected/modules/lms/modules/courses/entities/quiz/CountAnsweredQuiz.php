<?php

namespace Rendes\Modules\Courses\Entities\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * CountAnsweredQuiz
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\Courses\Repositories\QuizRepository")
 */
class CountAnsweredQuiz extends Quiz
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="need_count", type="integer", nullable=false)
	 */
	private $needCount;

	/**
	 * @param int $needCount
	 */
	public function setNeedCount($needCount)
	{
		$this->needCount = $needCount;
	}

	/**
	 * @return int
	 */
	public function getNeedCount()
	{
		return $this->needCount;
	}


	public function rules()
	{
		$rules = parent::rules();
		$rules[] = array('needCount', 'required');
		$rules[] = array('needCount', 'numerical');
		return $rules;
	}

	public function attributeNames()
	{
		$attributes = parent::attributeNames();
		$attributes[] = 'needCount';
		return $attributes;
	}

	public function getQuizTypeDescription()
	{
		return \Yii::t('quiz', 'You need to answer at least') . ' ' . $this->getNeedCount() . ' ' . \Yii::t('quiz', 'question(s)');
	}

}