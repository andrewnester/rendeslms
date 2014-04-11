<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Step */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'course-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>65,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php $this->widget('application.modules.lms.vendor.editMe.widgets.ExtEditMe', array(
			'model'=>$model,
			'attribute'=>'text',
		)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'backgroundColor'); ?>
		<?php $this->widget('application.modules.lms.vendor.colorpicker.EColorPicker',
			array(
				'value' => $model->backgroundColor,
				'name'=>'Rendes_Modules_Courses_Entities_Lecture_Slide[backgroundColor]',
				'mode'=>'textfield',
				'fade' => false,
				'slide' => false,
				'curtain' => true,
			)
		); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->