<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Entities\Lecture as Lecture;

class SlideService extends CourseBaseService
{

    public function populate(Lecture\Slide $slide, Lecture\Lecture $lecture, $documentData)
    {
        $slide->setName($documentData['name']);
        $slide->setDescription($documentData['description']);
        $slide->setLecture($lecture);
		$slide->setText($documentData['text']);

        return $slide;
    }

	public function getResultRepository()
	{
		// TODO: Implement getResultRepository() method.
	}


}