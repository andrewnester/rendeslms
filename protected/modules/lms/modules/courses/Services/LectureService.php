<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Interfaces as Interfaces;
use \Rendes\Modules\Courses\Interfaces\Services\ILearningActivityService;
use \Rendes\Modules\User\Entities\User;

class LectureService extends CourseBaseService implements ILearningActivityService
{

    /**
     * @var Interfaces\ResultRepositories\ILectureResultRepository
     */
    private $repository = null;

    /**
     * @return Interfaces\ResultRepositories\ILectureResultRepository
     */
    public function getResultRepository()
    {
        if(is_null($this->repository)){
            $this->repository = $this->loadResultRepository('lectures');
        }
        return $this->repository;
    }

    public function populate(\Rendes\Modules\Courses\Entities\Lecture\Lecture $lecture, \Rendes\Modules\Courses\Entities\Step $step, $lectureData)
    {
        $lecture->setName($lectureData['name']);
        $lecture->setDescription($lectureData['description']);
        $lecture->setStep($step);
        return $lecture;
    }

	/**
	 * @param \Rendes\Modules\Courses\Entities\Lecture\Lecture $activityObject
	 * @param \Rendes\Modules\User\Entities\Student $student
	 * @return bool
	 */
	public function isAvailableToStart($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return true;
	}

	/**
	 * @param \Rendes\Modules\Courses\Entities\Lecture\Lecture $activityObject
	 * @param \Rendes\Modules\User\Entities\Student $student
	 * @return bool
	 */
	public function isPassed($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		$videos = $activityObject->getVideos();
		$slides = $activityObject->getSlides();
		$documents = $activityObject->getDocuments();

		$videoService = \Yii::app()->getModule('lms')->getModule('courses')->videoService;
		$slideService = \Yii::app()->getModule('lms')->getModule('courses')->slideService;
		$documentService = \Yii::app()->getModule('lms')->getModule('courses')->documentService;

		foreach($videos as $video){
			if(!$videoService->isPassed($video, $student)){
				return false;
			}
		}

		foreach($slides as $slide){
			if(!$slideService->isPassed($slide, $student)){
				return false;
			}
		}

		foreach($documents as $document){
			if(!$documentService->isPassed($document, $student)){
				return false;
			}
		}

		return true;
	}

	public function currentProgress($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		$videos = $activityObject->getVideos();
		$slides = $activityObject->getSlides();
		$documents = $activityObject->getDocuments();

		$videoService = \Yii::app()->getModule('lms')->getModule('courses')->videoService;
		$slideService = \Yii::app()->getModule('lms')->getModule('courses')->slideService;
		$documentService = \Yii::app()->getModule('lms')->getModule('courses')->documentService;

		$progress = 0;
		foreach($videos as $video){
			$progress += $videoService->currentProgress($video, $student);
		}

		foreach($slides as $slide){
			$progress += $slideService->currentProgress($slide, $student);
		}

		foreach($documents as $document){
			$progress += $documentService->currentProgress($document, $student);
		}

		$allCount = (count($videos) + count($slides) + count($documents));
		return $allCount > 0 ? $progress / $allCount : 0 ;
	}

	/**
	 * @param \Rendes\Modules\Courses\Entities\Lecture\Lecture $activityObject
	 * @param \Rendes\Modules\User\Entities\Student $student
	 * @return bool
	 */
	public function isFailed($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return false;
	}

	/**
	 * @param \Rendes\Modules\Courses\Entities\Lecture\Lecture $activityObject
	 * @param \Rendes\Modules\User\Entities\Student $student
	 * @return bool
	 */
	public function isActive($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		$videos = $activityObject->getVideos();
		$slides = $activityObject->getSlides();
		$documents = $activityObject->getDocuments();

		$videoService = \Yii::app()->getModule('lms')->getModule('courses')->videoService;
		$slideService = \Yii::app()->getModule('lms')->getModule('courses')->slideService;
		$documentService = \Yii::app()->getModule('lms')->getModule('courses')->documentService;

		foreach($videos as $video){
			if($videoService->isActive($video, $student)){
				return true;
			}
		}

		foreach($slides as $slide){
			if($slideService->isActive($slide, $student)){
				return true;
			}
		}

		foreach($documents as $document){
			if($documentService->isActive($document, $student)){
				return true;
			}
		}

		return false;
	}

	public function getItemProgress(\Rendes\Modules\Courses\Entities\Lecture\Lecture $lecture, \Rendes\Modules\User\Entities\Student $student, $itemName)
	{
		$methodName = 'get'.ucfirst($itemName).'s';
		$service = $itemName.'Service';

		$items = $lecture->$methodName();
		$itemService = \Yii::app()->getModule('lms')->getModule('courses')->$service;
		$itemProgress = array();

		foreach($items as $item){
			$itemProgress[$item->getId()] = $itemService->currentProgress($item, $student);
		}

		return $itemProgress;
	}

}