<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Entities\Lecture as Lecture;

class DocumentsService extends CourseBaseService
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
}