<?php $this->widget('\Rendes\Widgets\LMSGridView', array(
    'ajaxUrl' => Yii::app()->createUrl('lms/courses/default/search'),
    'dataProvider'=>$dataProvider,
    'filter'=>$filter,
    'columns'=>array(
        array(
            'name'=>$filter->getAttributeLabel('name'),
            'type'=>'raw',
            'value'=>'CHtml::link($data["name"], Yii::app()->createUrl("/lms/courses/default/view", array("id" => $data["id"])))',
            'filter'=> CHtml::textField('Course[name]', $filter->getName()),
        ),
        array(
            'name'=> 'Teacher',
            'type' => 'text',
            'value' => '$data["teacher"]["name"]',
            'filter'=>CHtml::dropDownList("Course[teacher]" , $filter->getTeacher() , $teachers),
        ),
        array(
            'name'=> $filter->getAttributeLabel('description'),
            'type' => 'text',
            'value' => '$data["description"]',
            'filter'=> CHtml::textField('Course[description]', $filter->getDescription()),
        ),
        array(
            'name'=> $filter->getAttributeLabel('isPublic'),
            'type' => 'text',
            'value' => '$data["isPublic"] ? "Yes" : "No"',
            'filter'=> $this->checkAccess('administrator') ?
                CHtml::dropDownList('Course[isPublic]', $filter->getIsPublic(), array(""=>"", '1'=>'Yes', '0'=>'No')) : '',
            'htmlOptions' => array('style' => !$this->checkAccess('administrator') ? 'display:none' : ''),
            'headerHtmlOptions' => array('style' => !$this->checkAccess('administrator') ? 'display:none' : ''),
        ),
    )
));