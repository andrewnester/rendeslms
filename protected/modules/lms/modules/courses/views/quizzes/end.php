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

<h1>Results for Quiz "<?php echo $quiz->name; ?>"</h1>

<div id='quiz-final-page'  ng-show='endQuiz'>
	<p>You finished quiz!</p>
	<table>
		<tr>
			<td>Attempts:</td>
			<td><?php echo count($attempts); ?></td>
		</tr>
		<tr>
			<td>Total:</td>
			<td><?php echo count($quiz->getQuestions()); ?></td>
		</tr>
		<tr>
			<td>Total answered:</td>
			<td><?php echo count($answers); ?></td>
		</tr>
		<tr>
			<td>Right answers:</td>
			<td><?php echo count($rightAnswers); ?></td>
		</tr>
	</table>
</div>

<hr/>
