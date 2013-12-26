<?php
/* @var $this CourseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Courses',
);

$this->menu=array();

if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create Course', 'url'=>array('create'));
}


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

");
?>

<h1>Courses</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
    <div class="search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
            'model'=>$domain,
            'teachers' => $teachers
        )); ?>
    </div><!-- search-form -->

<?php $this->widget('LMSGridView', array(
	'dataProvider'=>$dataProvider,
    'filter'=>$domain,
    'columns'=>array(
        array(
            'name'=>$domain->getAttributeLabel('name'),
            'type'=>'raw',
            'value'=>'CHtml::link($data->getName(), "?r=lms/courses/default/view&id=$data->id")',
            'filter'=> CHtml::textField('Course[name]', $domain->getName()),
        ),
        array(
            'name'=> 'Teacher',
            'type' => 'text',
            'value' => '$data->teacher->getName()',
            'filter'=>CHtml::dropDownList("Course[teacher]" , $domain->getTeacher() , $teachers),
        ),
        array(
            'name'=> $domain->getAttributeLabel('description'),
            'type' => 'text',
            'value' => '$data->getDescription()',
            'filter'=> CHtml::textField('Course[description]', $domain->getDescription()),
        ),
        array(
            'name'=> $domain->getAttributeLabel('isPublic'),
            'type' => 'text',
            'value' => '$data->getIsPublic() ? \'Yes\' : \'No\'',
            'filter'=> $this->checkAccess('administrator') ?
                CHtml::dropDownList('Course[isPublic]', $domain->getIsPublic(), array(""=>"", '1'=>'Yes', '0'=>'No')) : '',
            'htmlOptions' => array('style' => !$this->checkAccess('administrator') ? 'display:none' : ''),
            'headerHtmlOptions' => array('style' => !$this->checkAccess('administrator') ? 'display:none' : ''),
        ),
    )
));

