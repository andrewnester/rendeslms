<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Course */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
);

?>

<h1>View Breakdown of Step #<?php echo $step->id; ?> for student "<?php echo $student->getFio(); ?>"</h1>

<h2>Lectures</h2>
<table>
	<thead>
		<tr>
			<th>Lecture</th>
			<th>Current Progress</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($lectures as $lecture): ?>
		<tr>
			<td><?php echo $lecture->getName(); ?></td>
			<td>
				<?php $this->widget('zii.widgets.jui.CJuiProgressBar',array(
					'value' => $lectureProgress[$lecture->getId()],
					'htmlOptions'=>array(
						'style'=>'height:10px;',
					),
				));
				?>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>

<hr/>
<h2>Tin Can Contents</h2>
<table>
	<thead>
	<tr>
		<th>Content</th>
		<th>Current Progress</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($tincans as $tincan): ?>
		<tr>
			<td><?php echo $tincan->getName(); ?></td>
			<td>
				<?php $this->widget('zii.widgets.jui.CJuiProgressBar',array(
					'value' => $tincanProgress[$tincan->getId()],
					'htmlOptions'=>array(
						'style'=>'height:10px;',
					),
				));
				?>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>

<hr/>
<h2>Quizzes</h2>
<table>
	<thead>
	<tr>
		<th>Quiz</th>
		<th>Status</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($quizzes as $quiz): ?>
		<tr>
			<td><?php echo $quiz->getName(); ?></td>
			<td><?php echo $quizPassingResults[$quiz->getId()] ?></td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>

