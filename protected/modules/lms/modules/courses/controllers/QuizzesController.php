<?php

namespace Rendes\Modules\Courses\Controllers;

class QuizzesController extends \Rendes\Controllers\LMSController
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
            array('allow',
                'roles' => array('administrator', 'teacher', 'student'),
            ),
            array('deny')
        );
    }





    public function actionUpdate($id, $stepID, $courseID)
    {
		try{
			$quiz = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Quiz')->getByID($id);
			$step = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Step')->getByID($stepID);
		}catch(\Exception $e){
			throw new \CHttpException(404, 'Such step does not exist');
		}

		$type = $quiz->getType();

		$quizData = $this->getHttpClient()->get('Rendes_Modules_Courses_Entities_Quiz_'.$type);
		$quizService = new \Rendes\Modules\Courses\Services\QuizService();

		if(!is_null($quizData))
		{
			$quiz = $quizService->populate($quiz, $step, $quizData);
			if($quiz->validate()){
				$this->getEntityManager()->flush();
				$this->redirect(array('/lms/courses/steps/view', 'id' => $stepID, 'courseID' => $courseID));
			}
		}

        $this->render('update', array(
            'model'=>$quiz,
            'type' => strtolower($type),
            'widgets' => $quizService->getAvailableWidgets(),
        ));
    }



    public function actionStart($id)
    {
        try{
            $quiz = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Quiz')->getByID($id);
        }catch(\Exception $e){
            throw new \CHttpException(404, 'Such quiz does not exist');
        }

        $quizService = new \Rendes\Modules\Courses\Services\QuizService();

        $userEntity = $this->getUser()->getEntity();
        if(!$quizService->isAvailableToStart($quiz, $userEntity)){
            $this->render('quiz_unavailable');
            die();
        }

        $widget = $quizService->getQuizWidget($quiz);

		$sessionID = $quizService->getXAPI()->getCurrentSession($userEntity);
		if($sessionID === false){
			$sessionID = $quizService->getXAPI()->startSession($userEntity);
			$statement = $quizService->prepareAttemptStatement($sessionID, $quiz, $userEntity);
			$isRecorded = $quizService->getResultRepository()->recordStatement($statement);
			if(!$isRecorded){
				throw new \CHttpException(500, 'Learning Record Store Error - Quiz can not be started. Please contact administrator');
			}
		}

		$answeredQuestions = $quizService->getResultRepository()->getAnsweredQuestions($quiz, $userEntity, $sessionID);
        $this->render('start', array('quiz' => $quiz, 'widget' => $widget, 'answeredQuestions' => $answeredQuestions));
    }


	public function actionEnd($id)
	{
		try{
			$quiz = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Quiz')->getByID($id);
		}catch(\Exception $e){
			throw new \CHttpException(404, 'Such quiz does not exist');
		}

		$quizService = new \Rendes\Modules\Courses\Services\QuizService();

		$userEntity = $this->getUser()->getEntity();
		$sessionID = $this->getXAPI()->getCurrentSession($userEntity);
		if(!$sessionID){
			throw new \CHttpException(500, 'Learning Record Store Error - Quiz can not be ended. There is no session started.');
		}

		$isRecorded = $quizService->getXAPI()->endSession($userEntity, $sessionID);
		if(!$isRecorded){
			throw new \CHttpException(500, 'Learning Record Store Error - Quiz can not be started. Please contact administrator');
		}

		$this->render('end', array(
			'quiz' => $quiz,
			'answers' => $quizService->getResultRepository()->getAnsweredQuestions($quiz, $userEntity, $sessionID),
			'rightAnswers' => $quizService->getResultRepository()->getRightAnsweredQuestions($quiz, $userEntity, $sessionID),
			'attempts' => $quizService->getResultRepository()->getAttempts($quiz, $userEntity),
		));
	}


    public function actionCreate($stepID, $courseID)
    {
		$type = $this->getHttpClient()->get('type', 'Quiz');
		$quiz = $this->safeClassLoad('\\Rendes\\Modules\\Courses\\Entities\\Quiz\\'.$type);

        try{
            $step = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Step')->getByID($stepID);
        }catch(\Exception $e){
            throw new \CHttpException(404, 'Such step does not exist');
        }

        $quizData = $this->getHttpClient()->get('Rendes_Modules_Courses_Entities_Quiz_'.$type);
        $quizService = new \Rendes\Modules\Courses\Services\QuizService();

        if(!is_null($quizData))
        {
            $quiz = $quizService->populate($quiz, $step, $quizData);
            if($quiz->validate()){
                $this->getEntityManager()->persist($quiz);
                $this->getEntityManager()->flush();
                $this->redirect(array('/lms/courses/steps/view', 'id' => $stepID, 'courseID' => $courseID));
            }
        }

		$hashService = new \Rendes\Services\HashService();

        $this->render('create',array(
            'step' => $step,
			'activeTab' => $hashService->hash(get_class($quiz)),
			'tabs' => $quizService->generateTabs($quiz)
        ));
    }




    public function actionView($id, $stepID, $courseID)
    {
        $quizService = new \Rendes\Modules\Courses\Services\QuizService();
        $quiz = $this->loadQuiz($id);
        $userEntity = $this->getUser()->getEntity();

        $this->render('view',array(
            'model' =>  $quiz,
            'rules' => $quizService->getAvailableTypes(),
            'widgets' => $quizService->getAvailableWidgets(),
            'attemptCount' => $quizService->getResultRepository()->getAttemptCount($quiz, $userEntity),
            'stepID' => $stepID,
            'courseID' => $courseID
        ));
    }




    public function actionOrder($stepID, $courseID)
    {
        $orderData = $this->getHttpClient()->get('order');
        if(!$orderData){
            $this->redirect(array('/lms'));
        }
        $quizService = new \Rendes\Modules\Courses\Services\QuizService();
        $quizIterator = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Quiz')->getByIDArray(array_values($orderData));
        foreach($quizIterator as $quiz){
            $quiz->setOrder($quizService->countOrder($orderData, $quiz->getId()));
        }

        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();

        $this->getHttpClient()->json(array('message' => 'Successfully Saved'));
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
