<?php
/**
 * User: nester_a
 * Date: 11.04.14
 */

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'assign-teacher-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<h1>Assign Teacher to Course "<?php echo $course->getName(); ?>"</h1>

<div class="row">
	Choose teacher: <?php echo CHtml::dropDownList('teacher_id', 0, $teachers) ?>
</div>

<div class="row buttons">
	 <?php echo CHtml::submitButton('Assign'); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->