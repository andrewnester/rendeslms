<?php
/* @var $this \Rendes\Modules\Courses\Controllers\DefaultController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'LMS' => array('/lms'),
    'Groups',
);

$this->menu=array();

if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create Group', 'url'=>array('create'));
}

?>

<?php $this->widget('\Rendes\Modules\User\Modules\Marks\Widgets\StudentMarksWidget', array(
	'studentCourses' => $studentCourses,
	'marks' => $marks,
	'student' => $student,
	'studentProgress' => $studentProgress,
	'isAdmin' => $this->checkAccess('teacher')
));


