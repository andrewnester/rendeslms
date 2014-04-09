<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Quiz\Questions\Question */
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