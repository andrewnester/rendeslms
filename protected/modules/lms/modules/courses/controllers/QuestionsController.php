<?php

namespace Rendes\Modules\Courses\Controllers;

class QuestionsController extends \Rendes\Controllers\LMSController
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
            'model' => $lecture,
            'rules' => $lecturesService->getAvailableRules(),
            'step' => $step,
        ));
    }




    public function actionCreate($quizID, $stepID, $courseID)
    {
        $questionType = $this->getRequest()->get('type', 'Question');
        try{
            $className = "\\Rendes\\Modules\\Courses\\Entities\\Quiz\\Questions\\".$questionType;
            $question = new $className();
            $quiz = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Quiz')->getByID($quizID);
        }catch(\Exception $e){
            throw new \CHttpException(404, 'Such step does not exist');
        }

        $questionData = $this->getRequest()->get('Rendes_Modules_Courses_Entities_Quiz_Questions_'.$questionType);
        $question->setAttributes($questionData);

        $questionService = new \Rendes\Modules\Courses\Services\QuestionService();

        if(!is_null($questionData) && $question->validate())
        {
            $method = 'populate'.$questionType;
            $question = $questionService->$method($question, $questionData);
            $this->getEntityManager()->persist($question);

            $quiz->getQuestions()->add($question);
            $this->getEntityManager()->flush();

            $this->redirect(array('/lms/courses/steps/view', 'id' => $stepID, 'courseID' => $courseID));
        }

        $this->render('create',array(
            'model'=>$question,
            'types' => $questionService->getAvailableTypes()
        ));
    }




    public function actionView($id, $stepID, $courseID)
    {
        $this->render('view',array(
            'model' => $this->loadQuiz($id),
            'stepID' => $stepID,
            'courseID' => $courseID
        ));
    }




    public function actionForm()
    {
        $questionType = $this->getRequest()->get('questionType');

        try{
            $className = '\\Rendes\\Modules\\Courses\\Entities\\Quiz\\Questions\\'.$questionType;
            $question = new $className();
        }catch(\Exception $e){
            $this->getRequest()->json(array('error' => 'There is no such question type'), 500);
        }

        $this->renderPartial('_' . strtolower($questionType), array(
            'model' => $question
        ));
    }





    protected function loadQuiz($id)
    {
        try{
            $quiz = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Quiz')->getByID($id);
        }
        catch(\Exception $e){
            throw new \CHttpException(404,'The requested page does not exist.');
        }

        return $quiz;
    }

}