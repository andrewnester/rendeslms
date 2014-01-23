<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Modules\Courses\Interfaces\ResultRepositories;

interface ILectureResultRepository
{
    public function getUserPassedDocuments($lectureID, $userID);
    public function getUserPassedVideos($lectureID, $userID);
}