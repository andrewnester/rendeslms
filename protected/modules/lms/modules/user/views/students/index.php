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


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

");
?>

<h1>Students</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
    <div class="search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
            'model'=>$domain,
        )); ?>
    </div><!-- search-form -->

<?php $this->widget('LMSGridView', array(
	'dataProvider'=>$dataProvider,
    'filter'=>$domain,
    'columns'=>array(
        array(
            'name'=>$domain->getAttributeLabel('name'),
            'type'=>'raw',
            'value'=>'CHtml::link($data->getName(), "?r=lms/user/students/view&id=$data->id")',
            'filter'=> CHtml::textField('Student[name]', $domain->getName()),
        ),
        array(
            'name'=> $domain->getAttributeLabel('email'),
            'type' => 'text',
            'value' => '$data->getEmail()',
            'filter'=> CHtml::textField('Student[email]', $domain->getEmail()),
        ),
        array(
            'name'=> $domain->getAttributeLabel('created'),
            'type' => 'text',
            'value' => '$data->getCreated()->format(\'Y-m-d H:i:s\')',
            'filter'=> CHtml::dateField('Student[created]', $domain->getCreated()),
        ),
    )
));

