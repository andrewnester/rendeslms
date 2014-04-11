<?php
/* @var $this CourseController */
/* @var $model Course */

$this->breadcrumbs=array(
	'Courses'=>array('/lms/courses'),
     $course->name => array('/lms/courses/default/view', 'id'=>$course->id),
	'Create',
);

?>

<h1>Create Step</h1>

<?php $this->renderPartial('_form', array(
    'model' => $model,
)); ?>