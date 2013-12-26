<?php

class DefaultController extends LMSController
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
                'actions'=>array('index'),
                'users'=> array('*'),
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
            'model'=>$this->loadCourse($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $course = new Course();

        $courseData = $this->getRequest()->get('Course');
        if(!is_null($courseData))
        {
            $course->setName($courseData['name']);
            $course->setDescription($courseData['description']);
            $course->setIsPublic($courseData['isPublic']);

            $teacher = $this->getEntityManager()
                            ->getRepository('User')
                            ->findOneBy(array('id' => $this->getUser()->id));

            $course->setTeacher($teacher);
            $this->getEntityManager()->persist($course);
            $this->getEntityManager()->flush();
            $this->redirect(array('view','id'=>$course->getId()));
        }

        $this->render('create',array(
            'model'=>$course,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $course=$this->loadCourse($id);

        $courseData = $this->getRequest()->get('Course');
        if(!is_null($courseData))
        {
            $course->setName($courseData['name']);
            $course->setDescription($courseData['description']);
            $course->setIsPublic($courseData['isPublic']);
            $this->getEntityManager()->flush();
            $this->redirect(array('view','id'=>$course->id));
        }

        $this->render('update',array(
            'model'=>$course,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $course = $this->loadCourse($id);
        $this->getEntityManager()->remove($course);
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
            'name', 'description'
        );

        $courseParams = $this->getRequest()->get('Course', array());
        $searchParams = array();
        foreach($courseParams as $key=>$value){
            if(strlen($value) > 0){
                $searchParams[] = array(
                    'key' => $key,
                    'value' => in_array($key, $likeParams) ? '%' . $value . '%' : $value,
                    'type' => in_array($key, $likeParams) ? ' LIKE ' : ' = ',
                );
            }
        }

        if(!$this->checkAccess('administrator')){
            $searchParams[] = array(
                'key' => 'isPublic',
                'value' => 1,
                'type' => ' = ',
            );
        }

        $criteria->params = $searchParams;
        $dataProvider = $this->getEntityManager()->getRepository('Course');

        $dataProvider->setCriteria($criteria);

        $teachers = $this->getEntityManager()->getRepository('User')->findBy(array('role' => array('teacher', 'administrator')));
        $teachersList = array(
            "" => ""
        );
        foreach($teachers as $teacher){
            $teachersList[$teacher->getId()] = $teacher->getName();
        }

        $domain = new Course();
        $domain->setAttributes($courseParams, false);

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
            'teachers' => $teachersList,
            'domain' => $domain
        ));
    }




    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Course the loaded model
     * @throws CHttpException
     */
    private function loadCourse($id)
    {
        $entityManager = $this->getEntityManager();

        $course = $entityManager->find('Course', $id);
        if($course===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $course;
    }

}
