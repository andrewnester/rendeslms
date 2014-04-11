<?php
/* @var $this CourseController */
/* @var $model Course */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
);

?>

<h1>Create Teacher</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'isNewRecord' => true)); ?>