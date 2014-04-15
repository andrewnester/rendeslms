<?php
/* @var $this StudentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Students',
);

$this->menu=array();

if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create Student', 'url'=>array('create'));
}


?>

<h1>Students</h1>

<?php $this->widget('\Rendes\Widgets\LMSGridView', array(
	'dataProvider'=>$dataProvider,
    'filter'=>$domain,
    'columns'=>array(
        array(
            'name'=>$domain->getAttributeLabel('name'),
            'type'=>'raw',
            'value'=>'CHtml::link($data->getName(), "?r=lms/user/students/view&id=$data->id")',
            'filter'=> CHtml::textField('Grid[name]', $domain->getName()),
        ),
        array(
            'name'=> $domain->getAttributeLabel('email'),
            'type' => 'text',
            'value' => '$data->getEmail()',
            'filter'=> CHtml::textField('Grid[email]', $domain->getEmail()),
        ),
        array(
            'name'=> $domain->getAttributeLabel('created'),
            'type' => 'text',
            'value' => '$data->getCreated()->format(\'Y-m-d H:i:s\')',
            'filter'=> CHtml::dateField('Grid[created]', $domain->getCreated()),
        ),
    )
));

