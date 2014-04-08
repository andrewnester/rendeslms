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

<h2>Quiz Type</h2>
<div class="row">
	<p><?php echo $model->getQuizTypeDescription(); ?></p>
</div>
<hr/>

<h2>Widget To Display Quiz</h2>
<?php $widget = $model->getwidget(); ?>
<?php if(count($widget) > 0): ?>
    <table>
        <?php foreach($widget as $widgetID => $options): ?>
            <tr>
                <td><?php echo $widgets[$widgetID]['name'] ?></td>
                <td>
                    <?php echo $widgets[$widgetID]['description'] ?>
                    <?php foreach($options['options'] as $option => $value): ?>
                        <p><strong><?php echo $widgets[$widgetID]['fields'][$option]['label'] ?>:</strong> <?php echo $value ?></p>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>There are no widgets</p>
<?php endif; ?>

<?php if($this->checkAccess('teacher')): ?>
    <?php $this->widget('\Rendes\Widgets\ElementRenderWidget', array(
        'name' => 'Questions',
        'header' => 'Questions',
        'nameField' => 'Title',
        'descriptionField' => 'Type',
        'model' => $model,
        'link' => '/lms/courses/questions',
        'order' => true,
        'linkParams' => array(
            'quizID' => $model->getId(),
            'stepID' => $model->getStep()->getId(),
            'courseID' => $model->getStep()->getCourse()->getId()
        )
    )); ?>

<?php else: ?>
    <button>Start Quiz</button>
<?php endif; ?>
