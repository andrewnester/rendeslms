<?php

namespace Rendes\Modules\User\Modules\Marks\Controllers;

class GroupController extends \Rendes\Controllers\LMSController
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
		return array();
	}


	public function actionCourse($itemID, $id)
	{
		try{
			$group = $this->getEntityManager()->getRepository('\Rendes\Modules\Groups\Entities\Group')->getByID($itemID);
			$course = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Course')->getByID($id);
		}catch(\Exception $e){
			throw new \CHttpException(404,'The requested lecture or student does not exist.');
		}

		$marks = $this->getEntityManager()->getRepository('\Rendes\Modules\User\Modules\Marks\Entities\Mark')->getCourseMarks($course, $group);

		$this->render('course', array(
			'course' => $course,
			'steps' => $course->getSteps(),
			'students' => $group->getStudents(),
			'marks' => $marks
		));
	}


}
