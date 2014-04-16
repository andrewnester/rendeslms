<?php
/* @var $this \Rendes\Modules\Courses\Controllers\DefaultController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'LMS' => array('/lms'),
    'Groups',
);

$this->menu=array();

if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create Group', 'url'=>array('create'));
}

?>

<?php
	$this->widget('CTabView', array(
		'tabs' => $tabs
	));
?>

