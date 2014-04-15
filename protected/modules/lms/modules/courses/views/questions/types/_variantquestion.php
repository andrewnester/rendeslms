<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Quiz\Questions\Question */
/* @var $form CActiveForm */

?>

<script type="text/javascript">
    function addNewAnswer(el)
    {
        $( "<p><input type='text' name='Rendes_Modules_Courses_Entities_Quiz_Questions_VariantQuestion[answers][]'/></p>" ).insertBefore($(el));
    }

    function addNewVariant(el)
    {
        $( "<p><input type='text' name='Rendes_Modules_Courses_Entities_Quiz_Questions_VariantQuestion[variants][]'/></p>" ).insertBefore($(el));
    }
</script>


<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'question-form',
		'action' => isset($action) ? $action : 'create',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>65,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'question'); ?>
        <?php echo $form->textArea($model,'question',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'question'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'points'); ?>
		<?php echo $form->textField($model,'points',array('size'=>65,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'points'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'answers'); ?>
		<?php if(is_array($model->getAnswers())): ?>
			<?php foreach($model->getAnswers() as $answer): ?>
				<p><input type="text" name='Rendes_Modules_Courses_Entities_Quiz_Questions_VariantQuestion[answers][]' value="<?php echo $answer ?>"/></p>
			<?php endforeach; ?>
		<?php else: ?>
			<p><input type="text" name='Rendes_Modules_Courses_Entities_Quiz_Questions_VariantQuestion[answers][]'/></p>
		<?php endif; ?>
        <a onclick="addNewAnswer(this)">Add One More Answer</a>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'variants'); ?>
		<?php if(is_array($model->getVariants())): ?>
			<?php foreach($model->getVariants() as $variant): ?>
				<p><input type="text" name='Rendes_Modules_Courses_Entities_Quiz_Questions_VariantQuestion[variants][]' value="<?php echo $variant ?>"/></p>
			<?php endforeach; ?>
		<?php else: ?>
			<p><input type="text" name='Rendes_Modules_Courses_Entities_Quiz_Questions_VariantQuestion[variants][]'/></p>
		<?php endif; ?>
        <a onclick="addNewVariant(this)">Add One More Variant</a>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Save'); ?>
        <?php echo CHtml::hiddenField('type', 'VariantQuestion') ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->