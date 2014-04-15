<?php
$this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' =>'_item',
	'enablePagination' => true
));