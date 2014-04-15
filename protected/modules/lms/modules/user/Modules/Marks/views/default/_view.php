<?php
/* @var $this CourseController */
/* @var $data Course */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_public')); ?>:</b>
	<?php echo CHtml::encode($data->isPublic); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created->format('Y-m-d H:i:s')); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated')); ?>:</b>
	<?php echo CHtml::encode($data->updated->format('Y-m-d H:i:s')); ?>
	<br />

</div>
