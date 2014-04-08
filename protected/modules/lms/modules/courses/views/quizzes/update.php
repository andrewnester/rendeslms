<?php
/* @var $this CourseController */
/* @var $model Course */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
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

<h1>Update Quiz "<?php echo $model->name; ?>"</h1>

<?php $this->renderPartial('types/_'.$type, array('model' => $model, 'widgets' => $widgets, 'action' => 'update')); ?>