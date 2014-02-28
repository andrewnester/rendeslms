<?php
/* @var $this CourseController */
/* @var $quiz \Rendes\Modules\Courses\Entities\Quiz\Quiz */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$quiz->name,
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
);


if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create Quiz', 'url'=>array('create'));
    $this->menu[] = array('label'=>'Delete Quiz', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$quiz->id),'confirm'=>'Are you sure you want to delete this item?'));
}

?>

<h1>Passing Quiz "<?php echo $quiz->name; ?>"</h1>

<?php $widget->init(); ?>
<?php $widget->run(); ?>

<hr/>
