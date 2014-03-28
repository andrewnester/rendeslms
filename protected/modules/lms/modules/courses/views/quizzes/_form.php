<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Quiz\Quiz */
/* @var $form CActiveForm */
?>

<div class="form">
<?php
	$this->widget('CTabView', array(
		'tabs' => $tabs,
		'activeTab' => $activeTab
	));

?>
</div><!-- form -->