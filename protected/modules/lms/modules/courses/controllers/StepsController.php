<?php

namespace Rendes\Modules\Courses\Controllers;

use Rendes\Modules\Courses\Services\StepService;

class StepsController extends \Rendes\Controllers\LMSController
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




    public function actionUpdate($id, $courseID)
    {
        try{
            $course = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Course')->getByID($courseID);
            $step = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Step')->getByID($id);
        }catch(\Exception $e){
            throw new \CHttpException(404, 'There is no such step');
        }

        $stepData = $this->getHttpClient()->get('Rendes_Modules_Courses_Entities_Step');
        $step->setAttributes($stepData);

        $stepsService = new \Rendes\Modules\Courses\Services\StepService();

        if(!is_null($stepData) && $step->validate())
        {
            $step = $stepsService->populateStep($step, $course, $stepData);

            $this->getEntityManager()->persist($step);
            $this->getEntityManager()->flush();

            $this->redirect(array('/lms/courses/default/view','id' => $courseID));
        }

        $stepsList = $stepsService->getCourseStepsList($courseID);

        $this->render('update',array(
            'model'=>$step,
            'course' => $course,
            'steps' => $stepsList
        ));
    }

    public function actionCreate($courseID)
    {
        $step = new \Rendes\Modules\Courses\Entities\Step();
        try{
            $course = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Course')->getByID($courseID);
        }catch(\Exception $e){
            throw new \CHttpException(404, 'Such course does not exist');
        }

        $stepData = $this->getHttpClient()->get('Rendes_Modules_Courses_Entities_Step');
        $step->setAttributes($stepData);

        $stepsService = new \Rendes\Modules\Courses\Services\StepService();

        if(!is_null($stepData) && $step->validate())
        {
            $step = $stepsService->populateStep($step, $course, $stepData);

            $this->getEntityManager()->persist($step);
            $this->getEntityManager()->flush();

            $this->redirect(array('/lms/courses/default/view','id' => $courseID));
        }

        $stepsList = $stepsService->getCourseStepsList($courseID);

        $this->render('create',array(
            'model'=>$step,
            'course' => $course,
            'steps' => $stepsList
        ));
    }

    public function actionView($id, $courseID)
    {
        $this->render('view',array(
            'model'=>$this->loadStep($id),
            'courseID' => $courseID
        ));
    }



    protected function loadStep($id)
    {
        try{
            $step = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Step')->getByID($id);
        }
        catch(\Exception $e){
            throw new \CHttpException(404,'The requested page does not exist.');
        }

        return $step;
    }

}
