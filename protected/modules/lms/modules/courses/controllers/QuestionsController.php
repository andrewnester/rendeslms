<?php

namespace Rendes\Modules\Courses\Controllers;

use Rendes\Modules\Courses\Services\QuizService;

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


    public function actionValidate($id, $quizID, $stepID, $courseID)
    {
        try{
            $question = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Questions\Question')->getByID($id);
        }catch(\Exception $e){
            $this->getHttpClient()->json(array('error' => 'There is no such question'), 500);
        }

        $proposedAnswers = $this->getHttpClient()->get('answers');
        if(!$proposedAnswers){
            $this->getHttpClient()->json(array('error' => 'Please provide answers'), 400);
        }

        $validator = $question->getValidatorObject();
        $validationResult = $validator->validate($question->getAnswers(), $proposedAnswers);

        $questionService = new \Rendes\Modules\Courses\Services\QuestionService();

		$userEntity = $this->getUser()->getEntity();
		$sessionID = $this->getXAPI()->getCurrentSession($userEntity);
		if(!$sessionID){
			$this->getHttpClient()->json(array('isRight' => false), 500);
		}

        $statement = $questionService->prepareQuestionResultStatement($question, $userEntity, $sessionID, $validationResult, $courseID, $stepID, $quizID);
        $isRecorded = $questionService->getResultRepository()->recordStatement($statement);

        $this->getHttpClient()->json(array('isRight' => $validationResult), $isRecorded ? 200 : 500);
    }


    public function actionView($id, $quizID, $stepID, $courseID)
    {
        try{
            $questionArray = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Questions\Question')->getArrayResultByID($id);
			$question = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Questions\Question')->getByID($id);
        }catch(\Exception $e){
            $this->getHttpClient()->json(array('error' => 'There is no such question'), 500);
        }

		$userEntity = $this->getUser()->getEntity();
		$sessionID = $this->getXAPI()->getCurrentSession($userEntity);
		$questionService = new \Rendes\Modules\Courses\Services\QuestionService();
		$isAnswered = $questionService->isAnsweredQuestion($question, $userEntity, $sessionID);

        $this->getHttpClient()->json(array('question' => (array)$questionArray, 'answered' => $isAnswered), 200);
    }



    public function actionUpdate($id, $quizID, $stepID, $courseID)
    {
        try{
            $quiz = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Quiz')->getByID($quizID);
			$question = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Questions\Question')->getByID($id);
        }catch(\Exception $e){
            throw new \CHttpException(404, 'Such question does not exist');
        }

		$questionType = $question->getType();
        $questionData = $this->getHttpClient()->get('Rendes_Modules_Courses_Entities_Quiz_Questions_'.$questionType);
        $questionService = new \Rendes\Modules\Courses\Services\QuestionService();

		if(!is_null($questionData)){
			$method = 'populate'.$questionType;
			$question = $questionService->$method($question, $questionData);

			if($question->validate()){
				$this->getEntityManager()->flush();
				$this->redirect(array('/lms/courses/steps/view', 'id' => $stepID, 'itemID' => $courseID));
			}
		}

		$this->render('update', array(
			'model'=> $question,
			'type' => strtolower($questionType),
		));

    }




    public function actionCreate($quizID, $stepID, $courseID)
    {
        $questionType = $this->getHttpClient()->get('type', 'Question');
        try{
            \Yii::import('\\Rendes\\Modules\\Courses\\Entities\\Quiz\\Questions\\'.$questionType, true);
            $questionClass = new \ReflectionClass('\\Rendes\\Modules\\Courses\\Entities\\Quiz\\Questions\\'.$questionType);
            $question = $questionClass->newInstance();
            $quiz = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Quiz')->getByID($quizID);
        }catch(\Exception $e){
            throw new \CHttpException(404, 'Such step does not exist');
        }

        $questionData = $this->getHttpClient()->get('Rendes_Modules_Courses_Entities_Quiz_Questions_'.$questionType);

		$questionService = new \Rendes\Modules\Courses\Services\QuestionService();
		$method = 'populate'.$questionType;
		$question = $questionService->$method($question, $questionData);

        if(!is_null($questionData) && $question->validate())
        {
            $question->setQuiz($quiz);
			$this->getEntityManager()->persist($question);


            $quiz->getQuestions()->add($question);
            $this->getEntityManager()->flush();

            $this->redirect(array('/lms/courses/steps/view', 'id' => $stepID, 'courseID' => $courseID));
        }

		$hashService = new \Rendes\Services\HashService();

		$this->render('create',array(
			'activeTab' => $hashService->hash(get_class($question)),
			'tabs' => $questionService->generateTabs($question)
		));
    }


	public function actionOrder($quizID, $stepID, $courseID)
	{
		$orderData = $this->getHttpClient()->get('order');
		if(!$orderData){
			$this->redirect(array('/lms'));
		}
		$questionService = new \Rendes\Modules\Courses\Services\QuestionService();
		$questionIterator = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Questions\Question')->getByIDArray(array_values($orderData));
		foreach($questionIterator as $question){
			$question->setOrder($questionService->countOrder($orderData, $question->getId()));
		}

		$this->getEntityManager()->flush();
		$this->getEntityManager()->clear();

		$this->getHttpClient()->json(array('message' => 'Successfully Saved'));
	}


    public function actionQuestionOrder($quizID, $stepID, $courseID)
    {
        try{
            $quiz = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Quiz\Quiz')->getByID($quizID);
        }catch(\Exception $e){
            $this->getHttpClient()->json(array('error' => 'There is no such quiz'), 500);
        }


        $quizService = new \Rendes\Modules\Courses\Services\QuizService();
        $questionsOrder = $quizService->getQuestionsOrder($quiz);

        $this->getHttpClient()->json(array('order' => $questionsOrder), 200);
    }




    public function actionForm()
    {
        $questionType = $this->getHttpClient()->get('questionType');

        try{
            $className = '\\Rendes\\Modules\\Courses\\Entities\\Quiz\\Questions\\'.$questionType;
            $question = new $className();
        }catch(\Exception $e){
            $this->getHttpClient()->json(array('error' => 'There is no such question type'), 500);
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
