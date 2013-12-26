<?php

class StudentsController extends LMSController
{

    public $layout='//layouts/column2';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

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
                'actions'=>array('index'),
                'roles'=>array('administrator', 'teacher'),
            ),
            array('allow',
                'actions'=>array('create'),
                'roles'=>array('administrator', 'teacher'),
            ),
            array('allow',
                'actions'=>array('delete'),
                'roles'=>array('administrator', 'teacher'),
            ),
            array('allow',
                'actions'=>array('view'),
                'roles'=>array('administrator', 'teacher', 'student'),
            ),
            array('allow',
                'actions'=>array('update'),
                'roles'=>array('administrator', 'teacher'),
            ),
            array('deny'),
        );
    }




    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadUser($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $student = new User();

        $studentData = $this->getRequest()->get('User');
        if(!is_null($studentData))
        {
            $student->setName($studentData['name']);
            $student->setPassword($studentData['password']);
            $student->setEmail($studentData['email']);
            $student->setRole('student');

            $this->getEntityManager()->persist($student);
            $this->getEntityManager()->flush();
            $this->redirect(array('view','id'=>$student->getId()));
        }

        $this->render('create',array(
            'model'=>$student,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $student=$this->loadUser($id);

        $studentData = $this->getRequest()->get('User');
        if(!is_null($studentData))
        {
            $student->setName($studentData['name']);
            if(!empty($studentData['password'])){
                $student->setPassword($studentData['password']);
            }
            $student->setEmail($studentData['email']);

            $this->getEntityManager()->flush();
            $this->redirect(array('view','id'=>$student->id));
        }

        $this->render('update',array(
            'model'=>$student,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $student = $this->loadUser($id);
        $this->getEntityManager()->remove($student);
        $this->getEntityManager()->flush();
        $this->redirect(array('index'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $criteria = new CDbCriteria();

        $likeParams = array(
            'name', 'email', 'created'
        );

        $studentParams = $this->getRequest()->get('Student', array());
        $searchParams = array(
            array(
                'key' => 'role',
                'value' => 'student',
                'type' => ' = '
            )
        );
        foreach($studentParams as $key=>$value){
            if(!empty($value)){
                $searchParams[] = array(
                    'key' => $key,
                    'value' => in_array($key, $likeParams) ? '%' . $value . '%' : $value,
                    'type' => in_array($key, $likeParams) ? ' LIKE ' : ' = ',
                );
            }
        }

        $criteria->params = $searchParams;
        $dataProvider = $this->getEntityManager()->getRepository('User');
        $dataProvider->setCriteria($criteria);

        $domain = new User();
        $domain->setAttributes($studentParams, false);

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
            'domain' => $domain
        ));
    }



    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    private function loadUser($id)
    {
        $entityManager = $this->getEntityManager();

        $student = $entityManager->find('User', $id);
        if($student===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $student;
    }

}