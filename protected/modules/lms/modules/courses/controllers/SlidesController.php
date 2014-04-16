<?php

namespace Rendes\Modules\Courses\Controllers;

class SlidesController extends \Rendes\Controllers\LMSController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'LMSAccessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array();
    }


	public function actions()
	{
		return array(
			'order'=>array(
				'class'=>'\Rendes\Modules\Courses\Actions\OrderAction',
				'entityName'=>'\Rendes\Modules\Courses\Entities\Lecture\Slide',
				'serviceName'=>'\Rendes\Modules\Courses\Services\SlideService',
			),
			'create'=>array(
				'class'=>'Rendes\Modules\Courses\Actions\Lectures\CreateAction',
				'entityName'=>'\Rendes\Modules\Courses\Entities\Lecture\Slide',
				'serviceName'=>'\Rendes\Modules\Courses\Services\SlideService',
			),
			'update'=>array(
				'class'=>'Rendes\Modules\Courses\Actions\Lectures\UpdateAction',
				'entityName'=>'\Rendes\Modules\Courses\Entities\Lecture\Slide',
				'serviceName'=>'\Rendes\Modules\Courses\Services\SlideService',
			),
			'complete'=>array(
				'class'=>'Rendes\Modules\Courses\Actions\Lectures\MarkCompleteAction',
				'entityName'=>'\Rendes\Modules\Courses\Entities\Lecture\Slide',
				'serviceName'=>'\Rendes\Modules\Courses\Services\SlideService',
			)
		);
	}

    /**
     * Lists all models.
     */
    public function actionIndex($lectureID, $stepID, $courseID)
    {
        $this->renderPartial('index',array(
			'courseID' => $courseID,
			'stepID' => $stepID,
			'lectureID' => $lectureID,
            'slides' => $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Lecture\Slide')->getByLectureID($lectureID)
        ));
    }


    public function actionView($id, $stepID, $courseID)
    {
        $this->render('view',array(
            'model'=>$this->loadSlide($id),
            'courseID' => $courseID
        ));
    }

    protected function loadSlide($id)
    {
        try{
            $step = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Lecture\Slide')->getByID($id);
        }
        catch(\Exception $e){
            throw new \CHttpException(404,'The requested page does not exist.');
        }

        return $step;
    }



}
