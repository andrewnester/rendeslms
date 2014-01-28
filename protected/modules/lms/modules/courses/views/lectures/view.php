<?php
/* @var $this CourseController */
/* @var $model \Rendes\Modules\Courses\Entities\Lecture\Lecture */

$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
);


if($this->checkAccess('teacher')){
    $this->menu[] = array('label'=>'Create Lecture', 'url'=>array('create'));
    $this->menu[] = array('label'=>'Update Lecture', 'url'=>array('update', 'id'=>$model->id, 'stepID'=>$stepID, 'courseID'=>$courseID ));
    $this->menu[] = array('label'=>'Delete Lecture', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'));
}

?>

<h1>View Lecture "<?php echo $model->name; ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
    'attributes'=>array(
        array(
            'label'=>$model->getAttributeLabel('name'),
            'value'=>$model->getName(),
        ),
        array(
            'label'=>$model->getAttributeLabel('description'),
            'value'=>$model->getDescription(),
        ),
    ),
)); ?>

<hr/>
<h2>Documents</h2>
<?php $documents = $model->getDocuments(); ?>
<?php if(count($documents) > 0): ?>
    <table>
        <?php foreach($documents as $document): ?>
            <tr>
                <td>
                    <a href="<?php echo Yii::app()->createUrl('/lms/courses/documents/view', array(
                        'id' => $document->getId(),
                        'lectureID' => $model->getId(),
                        'stepID' => $model->getStep()->getId(),
                        'courseID' => $model->getStep()->getCourse()->getId())) ?>">

                    <?php echo $document->getName(); ?>
                    </a></td>
                <td><?php $document->getDescription() ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php $this->widget('\Rendes\Widgets\SortableListWidget', array(
        'id' => 'documents-order',
        'items' => $documents,
        'path' => Yii::app()->createUrl('/lms/courses/docuemnts/order', array('courseID' => $courseID,  'stepID' => $model->getID() )),
        'header' => 'Documents Order',
        'width' => 400
    )); ?>

<?php else: ?>
    <p>There are no documents</p>
<?php endif; ?>
<p><a href="<?php echo Yii::app()->createUrl('/lms/courses/documents/create', array('lectureID' => $model->getId(), 'stepID' => $model->getStep()->getId(), 'courseID' => $model->getStep()->getCourse()->getId())) ?>">Add New Document</a></p>

<hr/>
<h2>Videos</h2>
<?php $videos = $model->getVideos(); ?>
<?php if(count($videos) > 0): ?>
    <table>
        <?php foreach($videos as $video): ?>
            <tr>
                <td>
                    <a href="<?php echo Yii::app()->createUrl('/lms/courses/videos/view', array(
                        'id' => $video->getId(),
                        'lectureID' => $model->getId(),
                        'stepID' => $model->getStep()->getId(),
                        'courseID' => $model->getStep()->getCourse()->getId())) ?>">

                        <?php echo $video->getName(); ?>
                    </a></td>
                <td><?php $video->getDescription() ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>There are no videos</p>
<?php endif; ?>
<p><a href="<?php echo Yii::app()->createUrl('/lms/courses/videos/create', array('lectureID' => $model->getId(), 'stepID' => $model->getStep()->getId(), 'courseID' => $model->getStep()->getCourse()->getId())) ?>">Add New Video</a></p>

<h2>Passing Rules</h2>
<?php $passingRules = $model->getPassingRules(); ?>
<?php if(count($passingRules) > 0): ?>
    <table>
        <?php foreach($passingRules as $ruleID => $options): ?>
            <tr>
                <td><?php echo $rules[$ruleID]['name'] ?></td>
                <td>
                    <?php echo $rules[$ruleID]['description'] ?>
                    <?php foreach($options as $option => $value): ?>
                        <p><strong><?php echo $rules[$ruleID]['fields'][$option]['label'] ?>:</strong> <?php echo $value ?></p>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>There are no passing rules</p>
<?php endif; ?>