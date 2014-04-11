<?php
/* @var $this \Rendes\Modules\Courses\Controllers\DefaultController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'LMS' => array('/lms'),
    'Courses',
);

$this->menu=array();

if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create Course', 'url'=>array('create'));
}

?>

<h1>Courses</h1>
<?php $this->renderPartial('_grid',array(
    'dataProvider'=>$dataProvider,
    'filter'=>$domain,
)); ?>



