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

    <h4>Need to Pass</h4>
    <div class="row">
        <table>
            <tr>
                <td><strong>Documents</strong></td>
                <td><strong>Videos</strong></td>
            </tr>
            <tr>
                <td>
                    <?php $documents = $model->getDocuments(); ?>
                    <?php if(count($documents) > 0): ?>
                        <table>
                            <?php foreach($documents as $document): ?>
                                <tr>
                                    <td><label for='doc<?php echo $document->getId(); ?>' ><?php echo $document->getName(); ?></label>
                                        <input type="hidden" name='Rendes_Modules_Courses_Entities_Lecture_Lecture[documents][]' value="" />
                                        <input id='doc<?php echo $document->getId(); ?>' type="checkbox" name='Rendes_Modules_Courses_Entities_Lecture_Lecture[documents][]' value='<?php echo $document->getId(); ?>' />
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else: ?>
                        <p>There are no documents</p>
                    <?php endif; ?>
                </td>
                <td>
                    <?php $videos = $model->getVideos(); ?>
                    <?php if(count($videos) > 0): ?>
                        <table>
                            <?php foreach($videos as $video): ?>
                                <tr>
                                    <td><label for='doc<?php echo $video->getId(); ?>' ><?php echo $video->getName(); ?></label>
                                        <input type="hidden" name='Rendes_Modules_Courses_Entities_Lecture_Lecture[videos][]' value="" />
                                        <input id='doc<?php echo $video->getId(); ?>' type="checkbox" name='Rendes_Modules_Courses_Entities_Lecture_Lecture[videos][]' value='<?php echo $video->getId(); ?>' />
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else: ?>
                        <p>There are no videos</p>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <h3>Passing Rules</h3>
    <div class="row">
        <table>
        <?php $passingRules = $model->getPassingRules(); ?>
        <?php foreach($rules as $rule): ?>
            <tr>
                <td>
                    <label for='doc<?php echo $rule['id']; ?>' ><?php echo $rule['name']; ?></label>
                    <input type="hidden" name='Rendes_Modules_Courses_Entities_Lecture_Lecture[rules_id][]' value="" />
                    <input id='doc<?php echo $rule['id']; ?>' type="checkbox" name='Rendes_Modules_Courses_Entities_Lecture_Lecture[rules_id][]' value='<?php echo $rule['id']; ?>' <?php if(isset($passingRules[$rule['id']])): ?> checked="checked" <?php endif; ?>/>
                </td>
                <td>
                    <table>
                    <?php foreach($rule['fields'] as $field): ?>
                        <tr>
                            <td>
                                <label for="<?php echo $field['id'] ?>"><?php echo $field['label'] ?>:</label>
                            </td>
                            <td>
                                <?php $value = isset($passingRules[$rule['id']], $passingRules[$rule['id']][$field['name']]) ? $passingRules[$rule['id']][$field['name']] : $field['default']  ?>
                                <input type="<?php echo $field['type'] ?>" name="Rendes_Modules_Courses_Entities_Lecture_Lecture[rules][<?php echo $rule['id']; ?>][<?php echo $field['name'] ?>]" value="<?php echo $value ?>"/>
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