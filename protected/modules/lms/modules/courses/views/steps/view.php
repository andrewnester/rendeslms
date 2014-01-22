<?php
/* @var $this CourseController */
/* @var $model Course */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
);


if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create Step', 'url'=>array('create'));
    $this->menu[] = array('label'=>'Update Step', 'url'=>array('update', 'id'=>$model->id));
    $this->menu[] = array('label'=>'Delete Step', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'));
}

?>

<h1>View Step #<?php echo $model->id; ?></h1>

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
<h3>Required Steps</h3>
<?php $requiredSteps = $model->getRequiredSteps(); ?>
<?php if(count($requiredSteps) > 0): ?>
    <table>
        <?php foreach($requiredSteps as $step): ?>
            <tr>
                <td><a href='<?php echo Yii::app()->createUrl('lms/courses/steps/view', array('courseID' => $courseID,  'id' => $step->getID())) ?>'><?php echo $step->getName(); ?></a></td>
                <td><?php echo $step->getDescription(); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>There are no required steps</p>
<?php endif; ?>

<table>
</table>