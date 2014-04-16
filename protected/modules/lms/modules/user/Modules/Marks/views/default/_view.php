<?php

$this->widget('\Rendes\Modules\User\Modules\Marks\Widgets\StudentMarksWidget', array(
	'course' => $course,
	'marks' => $marks,
	'student' => $student,
	'studentProgress' => $studentProgress,
	'isAdmin' => $this->checkAccess('teacher')
));


