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

<h2>Student marks for course "<?php echo $course->getName() ?>"</h2>
<table>
	<thead>
		<tr>
			<th>Student\Steps</th>
			<?php foreach($steps as $step): ?>
				<th><?php echo $step->getName(); ?></th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
	<?php foreach($students as $student): ?>
		<tr>
			<td><a href='<?php echo \Yii::app()->createUrl('/lms/user/marks/default/index', array('userID' => $student->getId())) ?>'><?php echo $student->getName() ?></a></td>
			<?php foreach($steps as $step): ?>
				<td><?php echo $marks[$student->getId()][$step->getId()] ?></td>
			<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

