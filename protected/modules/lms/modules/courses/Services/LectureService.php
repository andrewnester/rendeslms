<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;

class LectureService extends \Rendes\Services\BaseService
{

    public function populate(\Rendes\Modules\Courses\Entities\Lecture\Lecture $lecture, \Rendes\Modules\Courses\Entities\Step $step, $lectureData)
    {
        $lecture->setName($lectureData['name']);
        $lecture->setDescription($lectureData['description']);
        $lecture->setStep($step);
        return $lecture;
    }


}