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

<h1>View Breakdown of Lecture #<?php echo $lecture->id; ?> for student "<?php echo $student->getFio(); ?>"</h1>

<h2>Documents</h2>
<table>
	<thead>
	<tr>
		<th>Document</th>
		<th>Current Progress</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($documents as $document): ?>
		<tr>
			<td><?php echo $document->getName(); ?></td>
			<td>
				<?php $this->widget('zii.widgets.jui.CJuiProgressBar',array(
					'value' => $documentProgress[$document->getId()],
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

<h2>Videos</h2>
<table>
	<thead>
	<tr>
		<th>Video</th>
		<th>Current Progress</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($videos as $video): ?>
		<tr>
			<td><?php echo $video->getName(); ?></td>
			<td>
				<?php $this->widget('zii.widgets.jui.CJuiProgressBar',array(
					'value' => $videoProgress[$video->getId()],
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

<h2>Slides</h2>
<table>
	<thead>
	<tr>
		<th>Slide</th>
		<th>Current Progress</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($slides as $slide): ?>
		<tr>
			<td><?php echo $slide->getName(); ?></td>
			<td>
				<?php $this->widget('zii.widgets.jui.CJuiProgressBar',array(
					'value' => $slideProgress[$slide->getId()],
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


