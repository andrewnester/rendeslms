<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Quiz\Questions\Question */
/* @var $form CActiveForm */

?>
<script type="text/javascript">
    function addNewAnswer(el)
    {
        $( "<p><input type='text' name='Rendes_Modules_Courses_Entities_Quiz_Questions_Question[answers][]'/></p>" ).insertBefore($(el));
    }
</script>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'question-form',
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
        <?php echo $form->labelEx($model,'weight'); ?>
        <?php echo $form->rangeField($model, 'weight') ?>
        <?php echo $form->error($model,'weight'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'answers'); ?>
        <p><input type="text" name='Rendes_Modules_Courses_Entities_Quiz_Questions_Question[answers][]'/></p>
        <a onclick="addNewAnswer(this)">Add One More Answer</a>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Save'); ?>
        <?php echo CHtml::hiddenField('type', 'Question') ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->