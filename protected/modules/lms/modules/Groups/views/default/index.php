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

<h1>Groups</h1>
<?php $this->renderPartial('_grid',array(
    'dataProvider'=>$dataProvider,
    'filter'=>$domain,
)); ?>



