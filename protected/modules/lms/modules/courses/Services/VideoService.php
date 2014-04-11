<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Entities\Lecture as Lecture;

class VideoService extends CourseBaseService
{

    public function populate(Lecture\Video $video, Lecture\Lecture $lecture, $documentData)
    {
        $video->setName($documentData['name']);
        $video->setDescription($documentData['description']);
        $video->setLecture($lecture);
        $video->setFile($documentData['file']);
        $video->setFile(\CUploadedFile::getInstance($video, 'file'));

        $docName = $this->prepareDocumentName($video->getFile()->getName());
        $video->getFile()->saveAs($this->getVideosRealPath() . $docName);
        $video->setSrc($this->getVideosPlayPath() . $docName);

        return $video;
    }

    public function getVideosPlayPath()
    {
        return \Yii::app()->baseUrl . $this->getVideosDir();
    }

    public function getVideosRealPath()
    {
        return \Yii::app()->basePath . '/../' .$this->getVideosDir();
    }



    private function prepareDocumentName($name)
    {
        return time() . '_' . $name;
    }

    private function getVideosDir()
    {
        return '/assets/videos/';
    }

	public function getResultRepository()
	{
		// TODO: Implement getResultRepository() method.
	}


}