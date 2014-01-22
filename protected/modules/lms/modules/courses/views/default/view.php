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

<h1>View Course #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
    'attributes'=>array(
        array(
            'label'=>$model->getAttributeLabel('name'),
            'value'=>$model->getName(),
        ),
        array(
            'label'=>'Teacher Name',
            'value'=>$model->getTeacher()->getName(),
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

<h2>Course Steps</h2>
<?php $courseSteps = $model->getSteps(); ?>
<?php if(count($courseSteps) > 0): ?>
    <table>
    <?php foreach($courseSteps as $step): ?>
        <tr>
            <td><a href='<?php echo Yii::app()->createUrl('lms/courses/steps/view', array('courseID' => $model->getID(),  'id' => $step->getID())) ?>'><?php echo $step->getName(); ?></a></td>
            <td><?php echo $step->getDescription(); ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>There are no available steps</p>
<?php endif; ?>

<?php if($this->checkAccess('administrator')): ?>
    <a href='<?php echo Yii::app()->createUrl('/lms/courses/steps/create', array('courseID' => $model->getId())) ?>'>Add New Step</a>
<?php endif; ?>