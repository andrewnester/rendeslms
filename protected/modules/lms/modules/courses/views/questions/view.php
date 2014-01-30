<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Quiz\Quiz */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
);


if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create Quiz', 'url'=>array('create'));
    $this->menu[] = array('label'=>'Update Quiz', 'url'=>array('update', 'id'=>$model->id, 'stepID'=>$stepID, 'courseID'=>$courseID ));
    $this->menu[] = array('label'=>'Delete Quiz', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'));
}

?>

<h1>View Quiz "<?php echo $model->name; ?>"</h1>

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

<hr/>

<?php if($this->checkAccess('teacher')): ?>
    <?php $this->widget('\Rendes\Widgets\ElementRenderWidget', array(
        'name' => 'Questions',
        'header' => 'Questions',
        'model' => $model,
        'link' => '/lms/courses/questions',
        'order' => false,
        'linkParams' => array(
            'quizID' => $model->getId(),
            'stepID' => $model->getStep()->getId(),
            'courseID' => $model->getStep()->getCourse()->getId()
        )
    )); ?>

<?php else: ?>
    <button>Start Quiz</button>
<?php endif; ?>
