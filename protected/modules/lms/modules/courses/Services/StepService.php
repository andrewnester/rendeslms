<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;

use Rendes\Modules\Courses\Interfaces\Services\ILearningActivityService;
use Rendes\Modules\User\Entities\User;

class StepService extends CourseBaseService implements ILearningActivityService
{

    /**
     * @param \Doctrine\ORM\EntityManager $em
     * @param int $courseID
     * @return array
     */
    public function getCourseStepsList($courseID)
   {
       $steps = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Step')->getByCourseID($courseID);
       $stepsList = array();

       foreach($steps as $step){
           $stepsList[$step['id']] = $step['name'];
       }

       return $stepsList;
   }

    public  function populate(\Rendes\Modules\Courses\Entities\Step $step, \Rendes\Modules\Courses\Entities\Course $course, $stepData)
    {
        $step->setName($stepData['name']);
        $step->setDescription($stepData['description']);
        $step->setCourse($course);

        return $step;
    }

	public function getResultRepository()
	{
		// TODO: Implement getResultRepository() method.
	}

	/**
	 * @param \Rendes\Modules\Courses\Entities\Step $activityObject
	 * @param \Rendes\Modules\User\Entities\Student $student
	 * @return bool
	 */
	public function isAvailableToStart($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return true;
	}

	/**
	 * @param \Rendes\Modules\Courses\Entities\Step $activityObject
	 * @param \Rendes\Modules\User\Entities\Student $student
	 * @return bool
	 */
	public function isPassed($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		$lectures = $activityObject->getLectures();
		$quizzes = $activityObject->getQuizzes();
		$tincans = $activityObject->getTincan();

		$lectureService = \Yii::app()->getModule('lms')->getModule('courses')->lectureService;
		$quizService = \Yii::app()->getModule('lms')->getModule('courses')->quizService;
		$tincanService = \Yii::app()->getModule('lms')->getModule('courses')->tincanService;

		$isQuizzesPassed = true;
		foreach($quizzes as $quiz){
			$isQuizzesPassed = $isQuizzesPassed && $quizService->isPassed($quiz, $student);
		}

		$isLecturesPassed = true;
		foreach($lectures as $lecture){
			$isLecturesPassed  = $isLecturesPassed && $lectureService->isPassed($lecture, $student);
		}

		$isTincanPassed = true;
		foreach($tincans as $tincan){
			$isTincanPassed = $isTincanPassed && $tincanService->isPassed($tincan, $student);
		}

		return $isQuizzesPassed && $isLecturesPassed && $isTincanPassed;
	}

	/**
	 * @param \Rendes\Modules\Courses\Entities\Step $activityObject
	 * @param \Rendes\Modules\User\Entities\Student $student
	 * @return bool
	 */
	public function isFailed($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		$quizzes = $activityObject->getQuizzes();

		$quizService = \Yii::app()->getModule('lms')->getModule('courses')->quizService;

		$isQuizFailed = false;
		foreach($quizzes as $quiz){
			$isQuizFailed = $isQuizFailed || $quizService->isFailed($quiz, $student);
		}

		return $isQuizFailed;
	}

	/**
	 * @param \Rendes\Modules\Courses\Entities\Step $activityObject
	 * @param \Rendes\Modules\User\Entities\Student $student
	 * @return bool
	 */
	public function isActive($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		$quizzes = $activityObject->getQuizzes();

		$quizService = \Yii::app()->getModule('lms')->getModule('courses')->quizService;

		$isQuizActive = false;
		foreach($quizzes as $quiz){
			$isQuizActive = $isQuizActive || $quizService->isActive($quiz, $student);
		}

		return $isQuizActive;
	}

	/**
	 * @param \Rendes\Modules\Courses\Entities\Step $activityObject
	 * @param \Rendes\Modules\User\Entities\Student $student
	 * @return float
	 */
	public function currentProgress($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		$lectures = $activityObject->getLectures();
		$quizzes = $activityObject->getQuizzes();
		$tincans = $activityObject->getTincan();

		$lectureService = \Yii::app()->getModule('lms')->getModule('courses')->lectureService;
		$quizService = \Yii::app()->getModule('lms')->getModule('courses')->quizService;
		$tincanService = \Yii::app()->getModule('lms')->getModule('courses')->tincanService;

		$progress = 0;
		foreach($quizzes as $quiz){
			$progress += $quizService->currentProgress($quiz, $student);
		}

		foreach($lectures as $lecture){
			$progress += $lectureService->currentProgress($lecture, $student);
		}

		foreach($tincans as $tincan){
			$progress += $tincanService->currentProgress($tincan, $student);
		}


		$allCount = (count($lectures) + count($quizzes) + count($tincans));
		return $allCount > 0 ? $progress / $allCount : 0 ;
	}


}