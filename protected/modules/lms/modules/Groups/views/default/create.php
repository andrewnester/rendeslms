<?php
/* @var $this CourseController */
/* @var $model Course */

$this->breadcrumbs=array(
	'Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Groups', 'url'=>array('index')),
);

?>

<h1>Create Group</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>