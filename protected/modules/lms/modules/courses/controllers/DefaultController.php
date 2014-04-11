<?php

namespace Rendes\Modules\Courses\Controllers;

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
            array('allow',
                'actions'=>array('index', 'search'),
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


	public function actions()
	{
		return array(
			'create'=>array(
				'class'=>'\Rendes\Actions\CreateAction',
				'entityName'=>'\Rendes\Modules\Courses\Entities\Course',
				'serviceName'=>'\Rendes\Modules\Courses\Services\CourseService',
			),
			'update'=>array(
				'class'=>'\Rendes\Actions\UpdateAction',
				'entityName'=>'\Rendes\Modules\Courses\Entities\Course',
				'serviceName'=>'\Rendes\Modules\Courses\Services\CourseService',
			),
			'index'=>array(
				'class'=>'\Rendes\Actions\GridAction',
				'entityName'=>'\Rendes\Modules\Courses\Entities\Course'
			),
			'search'=>array(
				'class'=>'\Rendes\Actions\SearchAction',
				'entityName'=>'\Rendes\Modules\Courses\Entities\Course'
			),
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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return \Rendes\Modules\Courses\Entities\Course
     * @throws \CHttpException
     */
    private function loadCourse($id)
    {
        try{
            $course = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Course')->getByID($id);
        }
        catch(\Exception $e){
            throw new \CHttpException(404,'The requested page does not exist.');
        }
        return $course;
    }

}
