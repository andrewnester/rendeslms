<?php
/* @var $this CourseController */
/* @var $model Course */

\Yii::app()->clientScript->registerCoreScript('jquery');

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
);

if($this->checkAccess('student')){
    $this->menu[] = array('label'=>'View Course', 'url'=>array('view', 'id'=>$model->id));
}


if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create Course', 'url'=>array('create'));
}

?>

<h1>Update Question "<?php echo $model->title; ?>"</h1>

<?php $this->renderPartial('types/_'.$type, array('model' => $model, 'action' => 'update')); ?>