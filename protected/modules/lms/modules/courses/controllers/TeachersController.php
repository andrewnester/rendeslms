<?php

namespace Rendes\Modules\Courses\Controllers;

use Rendes\Modules\Courses\Services\StepService;

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
			'assign' => array(
				'class'=>'\Rendes\Actions\AssignAction',
				'entityName'=>'\Rendes\Modules\User\Entities\Teacher',
				'serviceName'=>'\Rendes\Modules\User\Services\TeacherService',
				'itemEntityName'=>'\Rendes\Modules\Courses\Entities\Course'
			),
			'unassign' => array(
				'class'=>'\Rendes\Actions\UnassignAction',
				'entityName'=>'\Rendes\Modules\User\Entities\Teacher',
				'serviceName'=>'\Rendes\Modules\User\Services\TeacherService',
				'itemEntityName'=>'\Rendes\Modules\Courses\Entities\Course'
			),
			'search' => array(
				'class'=>'\Rendes\Actions\SearchAction',
				'entityName'=>'\Rendes\Modules\User\Entities\Teacher',
				'view'=>'_list'
			),
		);
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
