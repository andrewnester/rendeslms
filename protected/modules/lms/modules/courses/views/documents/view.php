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
}

?>

<h1>View Document #<?php echo $model->id; ?></h1>

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
            'label'=>$model->getAttributeLabel('src'),
            'value'=>$model->getSrc(),
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

<?php $this->widget('\Rendes\Widgets\LMSDocumentViewerWidget', array('src' => $model->getSrc())) ?>
