<?php
/* @var $this CourseController */
/* @var $model Course */

$this->breadcrumbs=array(
	'Courses'=>array('/lms/courses'),
	'Create',
);

?>

<h1>Add Video</h1>

<?php $this->renderPartial('_form', array(
    'model' => $model,
)); ?>