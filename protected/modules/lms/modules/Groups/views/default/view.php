<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Course */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
);


if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create Course', 'url'=>array('create'));
    $this->menu[] = array('label'=>'Update Course', 'url'=>array('update', 'id'=>$model->id));
    $this->menu[] = array('label'=>'Delete Course', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'));
}

?>

<h1>View Group #<?php echo $model->id; ?></h1>

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
        array(
            'label'=>$model->getAttributeLabel('isPublic'),
            'value'=>$model->getIsPublic() == 0 ? 'No' : 'Yes',
        ),
        array(
            'label'=>$model->getAttributeLabel('created'),
            'value'=>$model->getCreated()->format('Y-m-d H:i:s'),
        ),
        array(
            'label'=>$model->getAttributeLabel('updated'),
            'value'=>$model->getUpdated()->format('Y-m-d H:i:s'),
        )
    ),
)); ?>

<hr/>

<h1>Teachers</h1>
<?php foreach($model->getTeachers() as $teacher): ?>
	<div class="row">
		<a href='<?php echo \Yii::app()->createUrl('/lms/user/view', array('id' => $teacher->getId())) ?>'><?php echo $teacher->getName() ?></a>
		<a href="<?php echo \Yii::app()->createUrl('/lms/courses/teachers/unassign', array('courseID' => $model->getID(), 'id' => $teacher->getID())) ?>">X</a>
	</div>
<?php endforeach; ?>
<a href='<?php echo \Yii::app()->createUrl('/lms/courses/teachers/assign', array('courseID' => $model->getID())) ?>'>Add New</a>

<?php $this->widget('\Rendes\Widgets\ElementRenderWidget', array(
	'name' => 'Steps',
	'header' => 'Course Steps',
	'model' => $model,
	'link' => '/lms/courses/steps',
	'linkParams' => array(
		'courseID' => $model->getID()
	)
)); ?>
