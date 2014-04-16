<?php
/**
 * User: nester_a
 * Date: 28.01.14
 */

namespace Rendes\Modules\User\Modules\Marks\Widgets;

class StudentMarksWidget extends \CWidget
{

    public $course = null;
	public $studentProgress = null;
	public $marks = null;
	public $student = null;
	public $isAdmin = false;

    public function run()
    {
        $this->renderContent();
    }

    public function renderContent()
    {
        include __DIR__ . "/student_marks/content.phtml";
    }


}