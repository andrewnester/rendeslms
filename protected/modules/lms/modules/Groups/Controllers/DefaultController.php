<?php

namespace Rendes\Modules\Groups\Controllers;

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
			'create'=>array(
				'class'=>'\Rendes\Actions\CreateAction',
				'entityName'=>'\Rendes\Modules\Groups\Entities\Group',
				'serviceName'=>'\Rendes\Modules\Groups\Services\GroupService',
			),
			'update'=>array(
				'class'=>'\Rendes\Actions\UpdateAction',
				'entityName'=>'\Rendes\Modules\Groups\Entities\Group',
				'serviceName'=>'\Rendes\Modules\Groups\Services\GroupService',
			),
			'index'=>array(
				'class'=>'\Rendes\Actions\GridAction',
				'entityName'=>'\Rendes\Modules\Groups\Entities\Group'
			),
			'search'=>array(
				'class'=>'\Rendes\Actions\SearchAction',
				'entityName'=>'\Rendes\Modules\Groups\Entities\Group'
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
            'model'=>$this->loadGroup($id),
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
