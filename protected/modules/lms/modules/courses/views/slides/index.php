<?php ob_start(); ?>
<html>
<head>
	<title></title>
</head>
<body>
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

?>

<?php $this->widget('\Rendes\Widgets\LMSPresentationWidget', array('slides' => $slides, 'theme' => 'moon')) ?>
</body>
</html>
<?php $output = ob_get_clean(); ?>
<?php  \Yii::app()->clientScript->render($output); ?>
<?php echo $output ?>






