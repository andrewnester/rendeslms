<?php
/* @var $this CourseController */
/* @var $model Course */

$this->breadcrumbs=array(
	'Courses'=>array('/lms/courses'),
	'Create Quiz',
);

?>

<h1>Create Question</h1>

<?php $this->renderPartial('_form', array(
	'tabs' => $tabs,
	'activeTab' => $activeTab,
)); ?>