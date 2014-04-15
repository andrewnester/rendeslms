<?php

namespace Rendes\Modules\Groups\Controllers;

class CoursesController extends \Rendes\Controllers\LMSController
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
			'assign' => array(
				'class'=>'\Rendes\Actions\AssignAction',
				'entityName'=>'\Rendes\Modules\Courses\Entities\Course',
				'serviceName'=>'\Rendes\Modules\Courses\Services\CourseService',
				'itemEntityName'=>'\Rendes\Modules\Groups\Entities\Group',
				'returnURL' => '/lms/groups/default/view'
			),
			'unassign' => array(
				'class'=>'\Rendes\Actions\UnassignAction',
				'entityName'=>'\Rendes\Modules\Courses\Entities\Course',
				'serviceName'=>'\Rendes\Modules\Courses\Services\CourseService',
				'itemEntityName'=>'\Rendes\Modules\Groups\Entities\Group',
				'returnURL' => '/lms/groups/default/view'
			),
			'search' => array(
				'class'=>'\Rendes\Actions\SearchAction',
				'entityName'=>'\Rendes\Modules\Courses\Entities\Course',
				'view'=>'_list'
			),
		);
	}

}
