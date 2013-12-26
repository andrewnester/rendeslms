<?php
/* @var $this StudentsController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
);


if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create User', 'url'=>array('create'));
    $this->menu[] = array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id));
    $this->menu[] = array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'));
}

?>

<h1>View Student #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
    'attributes'=>array(
        array(
            'label'=>$model->getAttributeLabel('name'),
            'value'=>$model->getName(),
        ),
        array(
            'label'=>$model->getAttributeLabel('role'),
            'value'=>$model->getRole(),
        ),
        array(
            'label'=>$model->getAttributeLabel('email'),
            'value'=>$model->getEmail(),
        ),
        array(
            'label'=>$model->getAttributeLabel('created'),
            'value'=>$model->getCreated()->format('Y-m-d H:i:s'),
        ),
        array(
            'label'=>$model->getAttributeLabel('modified'),
            'value'=>$model->getModified()->format('Y-m-d H:i:s'),
        )
    ),
)); ?>
