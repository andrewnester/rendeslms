<?php

namespace Rendes\Modules\User\Controllers;

class TeachersController extends \Rendes\Controllers\LMSController
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

	public function actions()
	{
		return array(
			'create'=>array(
				'class'=>'\Rendes\Modules\Courses\Actions\CreateAction',
				'entityName'=>'\Rendes\Modules\User\Entities\Teacher',
				'serviceName'=>'\Rendes\Modules\User\Services\TeacherService',
			)
		);
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
