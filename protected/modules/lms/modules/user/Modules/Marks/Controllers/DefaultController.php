<?php

namespace Rendes\Modules\User\Modules\Marks\Controllers;

class DefaultController extends \Rendes\Controllers\LMSController
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
        return array(
        );
    }


	public function actions()
	{
		return array(
		);
	}

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadGroup($id),
        ));
    }

	public function actionIndex($userID)
	{
		try{
			$student = $this->getEntityManager()->getRepository('\Rendes\Modules\User\Entities\Student')->getByID($userID);
		}catch(\Exception $e){
			throw new \CHttpException(404,'The requested student does not exist.');
		}

		$studentService = new \Rendes\Modules\User\Services\StudentService();
		$marksService = new \Rendes\Modules\User\Modules\Marks\Services\MarkService();

		$studentCourses = $studentService->getCourses($student);
		$studentProgress = $studentService->getAllProgress($student);
		$marks = $marksService->getStudentMarks($student);

		$hashService = new \Rendes\Services\HashService();

		$tabs = array();
		foreach($studentCourses as $course){
			$tabs[$hashService->hash($course->getName())] = array(
				'title' => $course->getName(),
				'view' => '_view',
				'data' => array(
					'course' => $course,
					'studentProgress' => $studentProgress,
					'student' => $student,
					'marks' => $marks
				)
			);
		}

		$this->render('index', array(
			'tabs' => $tabs
		));
	}

	public function actionSave($userID)
	{
		try{
			$student = $this->getEntityManager()->getRepository('\Rendes\Modules\User\Entities\Student')->getByID($userID);
		}catch(\Exception $e){
			$this->getHttpClient()->json('The requested student does not exist.', 400);
		}

		$marks = $this->getHttpClient()->getPost('Marks', null);
		if(is_null($marks)){
			$this->getHttpClient()->json('No marks sent', 401);
		}

		$markService = new \Rendes\Modules\User\Modules\Marks\Services\MarkService();
		$markService->saveMarks($marks, $student, $this->getUser()->getEntity());
		$this->getHttpClient()->json('Saved', 200);
	}

	public function actionStep($userID, $id)
	{
		try{
			$student = $this->getEntityManager()->getRepository('\Rendes\Modules\User\Entities\Student')->getByID($userID);
			$step = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Step')->getByID($id);
		}catch(\Exception $e){
			throw new \CHttpException(404,'The requested step or student does not exist.');
		}

		$lectures = $step->getLectures();
		$quizzes = $step->getQuizzes();
		$tincans = $step->getTincan();

		$lectureService = \Yii::app()->getModule('lms')->getModule('courses')->lectureService;
		$quizService = \Yii::app()->getModule('lms')->getModule('courses')->quizService;
		$tincanService = \Yii::app()->getModule('lms')->getModule('courses')->tincanService;

		$lecturesProgress = array();
		$quizPassingResults = array();
		$tincanProgress = array();

		foreach($quizzes as $quiz){
			if($quizService->isPassed($quiz, $student)){
				$quizPassingResults[$quiz->getId()] = 'Passed';
			}else{
				$quizPassingResults[$quiz->getId()] = $quizService->isActive($quiz, $student) ? 'Active' : 'Failed';
			}
		}

		foreach($lectures as $lecture){
			$lecturesProgress[$lecture->getId()] = $lectureService->currentProgress($lecture, $student);
		}

		foreach($tincans as $tincan){
			$tincanProgress[$tincan->getId()] = $tincanService->currentProgress($tincan, $student);
		}

		$this->render('breakdown', array(
			'student' => $student,
			'step' => $step,
			'lectureProgress' => $lecturesProgress,
			'tincanProgress' => $tincanProgress,
			'quizPassingResults' => $quizPassingResults,
			'lectures' => $lectures,
			'quizzes' => $quizzes,
			'tincans' => $tincans
		));


	}

	public function actionLecture($userID, $id)
	{
		try{
			$student = $this->getEntityManager()->getRepository('\Rendes\Modules\User\Entities\Student')->getByID($userID);
			$lecture = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Lecture\Lecture')->getByID($id);
		}catch(\Exception $e){
			throw new \CHttpException(404,'The requested lecture or student does not exist.');
		}

		$lectureService = new \Rendes\Modules\Courses\Services\LectureService();

		$this->render('lecture', array(
			'lecture' => $lecture,
			'student' => $student,
			'documents' => $lecture->getDocuments(),
			'videos' => $lecture->getVideos(),
			'slides' => $lecture->getSlides(),
			'documentProgress' => $lectureService->getItemProgress($lecture, $student, 'document'),
			'videoProgress' => $lectureService->getItemProgress($lecture, $student, 'video'),
			'slideProgress' => $lectureService->getItemProgress($lecture, $student, 'slide'),
		));
	}

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $course = $this->loadGroup($id);
        $this->getEntityManager()->remove($course);
        $this->getEntityManager()->flush();
        $this->redirect(array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return \Rendes\Modules\Courses\Entities\Course
     * @throws \CHttpException
     */
    private function loadGroup($id)
    {
        try{
            $group = $this->getEntityManager()->getRepository('\Rendes\Modules\Groups\Entities\Group')->getByID($id);
        }
        catch(\Exception $e){
            throw new \CHttpException(404,'The requested page does not exist.');
        }
        return $group;
    }

}
