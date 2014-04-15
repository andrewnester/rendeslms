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

<h1>Teachers</h1>

<?php $this->renderPartial('_grid', array('filter' => $domain, 'dataProvider' => $dataProvider)) ?>

