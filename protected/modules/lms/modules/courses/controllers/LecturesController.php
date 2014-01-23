<?php

namespace Rendes\Modules\Courses\Controllers;

class LecturesController extends \Rendes\Controllers\LMSController
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


    /**
     * Lists all models.
     */
    public function actionIndex($courseID)
    {
        $this->render('index',array(
            'steps' => $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Step')->getByCourseID($courseID)
        ));
    }

    public function actionUpdate($id, $stepID, $courseID)
    {
        try{
            $step = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Step')->getByID($stepID);
            $lecture = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Lecture\Lecture')->getByID($id);
        }catch(\Exception $e){
            throw new \CHttpException(404, 'Such lecture does not exist');
        }

        $lectureData = $this->getRequest()->get('Rendes_Modules_Courses_Entities_Lecture_Lecture');
        $lecture->setAttributes($lectureData);

        $lecturesService = new \Rendes\Modules\Courses\Services\LectureService();

        if(!is_null($lectureData) && $lecture->validate())
        {
            $lecture = $lecturesService->populate($lecture, $step, $lectureData);

            $this->getEntityManager()->persist($lecture);
            $this->getEntityManager()->flush();

            $this->redirect(array('/lms/courses/steps/view', 'id' => $stepID, 'courseID' => $courseID));
        }

        $this->render('update',array(
            'model'=>$lecture,
            'step' => $step,
        ));
    }

    public function actionCreate($stepID, $courseID)
    {
        $lecture = new \Rendes\Modules\Courses\Entities\Lecture\Lecture();
        try{
            $step = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Step')->getByID($stepID);
        }catch(\Exception $e){
            throw new \CHttpException(404, 'Such step does not exist');
        }

        $lectureData = $this->getRequest()->get('Rendes_Modules_Courses_Entities_Lecture_Lecture');
        $lecture->setAttributes($lectureData);

        $lecturesService = new \Rendes\Modules\Courses\Services\LectureService();

        if(!is_null($lectureData) && $lecture->validate())
        {
            $lecture = $lecturesService->populate($lecture, $step, $lectureData);

            $this->getEntityManager()->persist($lecture);
            $this->getEntityManager()->flush();

            $this->redirect(array('/lms/courses/steps/view', 'id' => $stepID, 'courseID' => $courseID));
        }

        $this->render('create',array(
            'model'=>$lecture,
            'step' => $step,
        ));
    }

    public function actionView($id, $stepID, $courseID)
    {
        $this->render('view',array(
            'model'=>$this->loadLecture($id),
            'stepID' => $stepID,
            'courseID' => $courseID
        ));
    }


    protected function loadLecture($id)
    {
        try{
            $lecture = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Lecture\Lecture')->getByID($id);
        }
        catch(\Exception $e){
            throw new \CHttpException(404,'The requested page does not exist.');
        }

        return $lecture;
    }



}
