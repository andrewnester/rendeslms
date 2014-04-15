<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Entities\Lecture as Lecture;
use Rendes\Modules\Courses\Interfaces\Services\ILearningActivityService;

class DocumentsService extends CourseBaseService implements ILearningActivityService
{

    public function populate(Lecture\Document $document, Lecture\Lecture $lecture, $documentData)
    {
        $document->setName($documentData['name']);
        $document->setDescription($documentData['description']);
        $document->setLecture($lecture);
        $document->setDoc($documentData['doc']);
        $document->setDoc(\CUploadedFile::getInstance($document, 'doc'));

        $docName = $this->prepareDocumentName($document->getDoc()->getName());
        $document->getDoc()->saveAs($this->getDocumentsRealPath() . $docName);
        $document->setSrc($this->getDocumentsDownloadPath() . $docName);

        return $document;
    }

    public function getDocumentsDownloadPath()
    {
        return \Yii::app()->baseUrl . $this->getDocumentsDir();
    }

    public function getDocumentsRealPath()
    {
        return \Yii::app()->basePath . '/../' .$this->getDocumentsDir();
    }

    private function prepareDocumentName($name)
    {
        return time() . '_' . $name;
    }

    private function getDocumentsDir()
    {
        return '/assets/docs/';
    }

	public function getResultRepository()
	{
		return $this->loadResultRepository('document');
	}



	public function isAvailableToStart($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return true;
	}

	public function isPassed($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return $this->getResultRepository()->getCountViewed($activityObject, $student) > 0;
	}

	public function isFailed($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return false;
	}

	public function isActive($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return !$this->isPassed($activityObject, $student);
	}

	public function currentProgress($activityObject, \Rendes\Modules\User\Entities\Student $student)
	{
		return $this->isPassed($activityObject, $student) ? 100 : 0;
	}


}