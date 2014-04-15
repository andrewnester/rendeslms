<?php $this->widget('\Rendes\Widgets\LMSGridView', array(
	'ajaxUrl' => Yii::app()->createUrl('lms/groups/default/search'),
	'dataProvider'=>$dataProvider,
	'filter'=>$filter,
	'columns'=>array(
		array(
			'name'=>$filter->getAttributeLabel('name'),
			'type'=>'raw',
			'value'=>'CHtml::link($data["name"], Yii::app()->createUrl("/lms/groups/default/view", array("id" => $data["id"])))',
			'filter'=> CHtml::textField('Grid[name]', $filter->getName()),
		),
		array(
			'name'=> $filter->getAttributeLabel('description'),
			'type' => 'text',
			'value' => '$data["description"]',
			'filter'=> CHtml::textField('Grid[description]', $filter->getDescription()),
		),
		array(
			'name'=> $filter->getAttributeLabel('isPublic'),
			'type' => 'text',
			'value' => '$data["isPublic"] ? "Yes" : "No"',
			'filter'=> $this->checkAccess('administrator') ?
				CHtml::dropDownList('Grid[isPublic]', $filter->getIsPublic(), array(""=>"", '1'=>'Yes', '0'=>'No')) : '',
			'htmlOptions' => array('style' => !$this->checkAccess('administrator') ? 'display:none' : ''),
			'headerHtmlOptions' => array('style' => !$this->checkAccess('administrator') ? 'display:none' : ''),
		),
	),
	'template'=>'{items}{pager}{summary}'
));