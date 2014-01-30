<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Lecture\Lecture */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lecture-form',
	'enableAjaxValidation'=>false,
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
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <h3>Passing Rule</h3>
    <div class="row">
        <table>
            <?php $passingRule = $model->getPassingRule(); ?>
            <?php foreach($rules as $rule): ?>
                <tr>
                    <td>
                        <label for='rule<?php echo $rule['id']; ?>' ><?php echo $rule['name']; ?></label>
                        <?php echo CHtml::radioButton('Rendes_Modules_Courses_Entities_Quiz_Quiz[rule_id]', false, array('id' => 'rule'.$rule['id'], 'value' => $rule['id']) ); ?>
                    </td>
                    <td>
                        <table>
                            <?php foreach($rule['fields'] as $field): ?>
                                <tr>
                                    <td>
                                        <label for="<?php echo $field['id'] ?>"><?php echo $field['label'] ?>:</label>
                                    </td>
                                    <td>
                                        <input type="<?php echo $field['type'] ?>" name="Rendes_Modules_Courses_Entities_Quiz_Quiz[rule][<?php echo $field['name'] ?>]" value=""/>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->