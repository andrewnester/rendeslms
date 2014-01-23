<?php
/* @var $this CourseController */
/* @var $model Course */

$this->breadcrumbs=array(
	'Courses'=>array('/lms/courses'),
     $step->course->name => array('/lms/courses/default/view', 'id'=> $step->course->getId()),
     $step->name => array('/lms/courses/steps/view', 'id'=>$step->getId(), 'courseID' => $step->course->getID()),
	'Create Lecture',
);

?>

<h1>Create Lecture</h1>

<?php $this->renderPartial('_form', array(
    'model' => $model,
)); ?>