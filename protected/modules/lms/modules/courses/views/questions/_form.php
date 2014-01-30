<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Quiz\Questions\Question */
/* @var $form CActiveForm */

?>


<?php $this->widget('\Rendes\Widgets\AjaxLoadOnRadioChangeWidget', array(
    'items' => $types,
    'name' => 'questionType',
    'path' => 'form'
)); ?>