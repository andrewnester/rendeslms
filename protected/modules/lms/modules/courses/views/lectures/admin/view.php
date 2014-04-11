<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Lecture\Lecture */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
);


if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create Lecture', 'url'=>array('create'));
    $this->menu[] = array('label'=>'Update Lecture', 'url'=>array('update', 'id'=>$model->id, 'stepID'=>$stepID, 'courseID'=>$courseID ));
    $this->menu[] = array('label'=>'Delete Lecture', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'));
}

?>

<h1>View Lecture "<?php echo $model->name; ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
    'attributes'=>array(
        array(
            'label'=>$model->getAttributeLabel('name'),
            'value'=>$model->getName(),
        ),
        array(
            'label'=>$model->getAttributeLabel('description'),
            'value'=>$model->getDescription(),
        ),
    ),
)); ?>


<?php $this->widget('\Rendes\Widgets\ElementRenderWidget', array(
	'name' => 'Documents',
	'header' => 'Documents',
	'model' => $model,
	'link' => '/lms/courses/documents',
	'linkParams' => array(
		'lectureID' => $model->getID(),
		'courseID' => $courseID,
		'stepID' => $stepID
	)
)); ?>

<?php $this->widget('\Rendes\Widgets\ElementRenderWidget', array(
	'name' => 'Slides',
	'header' => 'Slides',
	'model' => $model,
	'link' => '/lms/courses/slides',
	'linkParams' => array(
		'lectureID' => $model->getID(),
		'courseID' => $courseID,
		'stepID' => $stepID
	)
)); ?>

<?php $this->widget('\Rendes\Widgets\ElementRenderWidget', array(
	'name' => 'Videos',
	'header' => 'Videos',
	'model' => $model,
	'link' => '/lms/courses/videos',
	'linkParams' => array(
		'lectureID' => $model->getID(),
		'courseID' => $courseID,
		'stepID' => $stepID
	)
)); ?>