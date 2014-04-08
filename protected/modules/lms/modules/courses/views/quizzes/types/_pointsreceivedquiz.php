<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Quiz\PointsReceivedQuiz */
/* @var $form CActiveForm */

?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'point-received-quiz-form',
		'action' => isset($action) ? $action : 'create',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

    <?php echo $form->errorSummary($model); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

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

	<h3>Type</h3>

    <div class="row">
        <?php echo $form->labelEx($model,'points'); ?>
        <?php echo $form->textField($model,'points',array('size'=>65,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'points'); ?>
    </div>


	<h3>Widget To Display Quiz</h3>
	<div class="row">
		<table>
			<?php $widget = $model->getWidget(); ?>
			<?php $widgetID = !empty($widget) ? array_shift(array_keys($widget))  : false  ?>
			<?php foreach($widgets as $availableWidget): ?>
				<tr>
					<td>
						<label for='widget<?php echo $availableWidget['id']; ?>' ><?php echo $availableWidget['name']; ?></label>
						<?php echo CHtml::radioButton('Rendes_Modules_Courses_Entities_Quiz_PointsReceivedQuiz[widget_id]', $availableWidget['id'] == $widgetID , array('id' => 'widget'.$availableWidget['id'], 'value' => $availableWidget['id']) ); ?>
					</td>
					<td>
						<table>
							<?php foreach($availableWidget['fields'] as $field): ?>
								<tr>
									<td>
										<label for="<?php echo $field['id'] ?>"><?php echo $field['label'] ?>:</label>
									</td>
									<td>
										<?php $method=$field['type'];  ?>
										<?php echo CHtml::$method("Rendes_Modules_Courses_Entities_Quiz_PointsReceivedQuiz[widget][".$availableWidget['id']."][".$field['name']."]",
											isset($widget[$availableWidget['id']]['options'][$field['name']]) ? $widget[$availableWidget['id']]['options'][$field['name']] : $field['default']) ?>
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
		<?php echo CHtml::submitButton(Yii::t('quiz', 'Save')); ?>
        <?php echo CHtml::hiddenField('type', 'PointsReceivedQuiz') ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->