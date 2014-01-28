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
    $this->menu[] = array('label'=>'Update Step', 'url'=>array('update', 'id'=>$model->id, 'courseID'=>$model->course->id ));
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


<?php $this->widget('\Rendes\Widgets\ElementRenderWidget', array(
    'name' => 'RequiredSteps',
    'header' => 'Required Steps',
    'model' => $model,
    'link' => '/lms/courses/steps',
    'order' => false,
    'linkParams' => array(
        'courseID' => $courseID,
    )
)); ?>

<?php $this->widget('\Rendes\Widgets\ElementRenderWidget', array(
    'name' => 'Lectures',
    'header' => 'Lectures',
    'model' => $model,
    'link' => '/lms/courses/lectures',
    'linkParams' => array(
        'courseID' => $courseID,
        'stepID' => $model->getID()
    )
)); ?>

<?php $this->widget('\Rendes\Widgets\ElementRenderWidget', array(
    'name' => 'Quizzes',
    'header' => 'Quizzes',
    'model' => $model,
    'link' => '/lms/courses/quizzes',
    'linkParams' => array(
        'courseID' => $courseID,
        'stepID' => $model->getID()
    )
)); ?>

