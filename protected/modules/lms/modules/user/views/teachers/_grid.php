<?php $link = isset($link) ? $link : '/lms/user/default/view' ?>

<?php $this->widget('\Rendes\Widgets\LMSGridView', array(
	'ajaxUrl' => Yii::app()->createUrl('lms/user/teachers/search'),
	'dataProvider'=>$dataProvider,
	'filter'=>$filter,
	'columns'=>array(
		array(
			'name'=>$filter->getAttributeLabel('name'),
			'type'=>'raw',
			'value'=>'CHtml::link($data["name"], Yii::app()->createUrl("'.$link.'", array("id" => $data["id"])))',
			'filter'=> CHtml::textField('Grid[name]', $filter->getName()),
		),
		array(
			'name'=> $filter->getAttributeLabel('email'),
			'type' => 'text',
			'value' => '$data["email"]',
			'filter'=> CHtml::textField('Grid[email]', $filter->getEmail()),
		),
		array(
			'name'=> $filter->getAttributeLabel('degree'),
			'type' => 'text',
			'value' => '$data->getDegree()',
			'filter'=> CHtml::textField('Grid[degree]',  $filter->getDegree()),
		),
	),
	'template'=>'{items}{pager}{summary}'
));