<h1>Assign Course to Group "<?php echo $item->getName(); ?>"</h1>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assign-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


<?php $this->renderPartial('_list', array(
	'dataProvider' => $dataProvider,
));
?>

<div class="row buttons">
	<?php echo CHtml::submitButton('Assign'); ?>
</div>

<?php $this->endWidget(); ?>

