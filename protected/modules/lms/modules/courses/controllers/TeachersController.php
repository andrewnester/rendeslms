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


    public function actionAssign($courseID)
    {
        try{
            $course = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Course')->getByID($courseID);
        }catch(\Exception $e){
            throw new \CHttpException(404, 'Such course does not exist');
        }

        $teacherID = $this->getHttpClient()->get('teacher_id');
		$teacherService = new \Rendes\Modules\User\Services\TeacherService();

        if(!is_null($teacherID))
        {
			try{
				$teacher = $this->getEntityManager()->getRepository('\Rendes\Modules\User\Entities\Teacher')->getByID($teacherID);
			}catch(\Exception $e){
				throw new \CHttpException(404, 'Such teacher does not exist');
			}

			$teacher = $teacherService->assign($teacher, $course);
			try{
            	$this->getEntityManager()->flush();
			}catch(\Doctrine\DBAL\DBALException $e){
				$this->redirect(array('/lms/courses/default/view','id' => $courseID));
			}

            $this->redirect(array('/lms/courses/default/view','id' => $courseID));
        }

        $teacherList = $teacherService ->getTeachersList();

        $this->render('assign',array(
            'course' => $course,
            'teachers' => $teacherList
        ));
    }

	public function actionUnassign($courseID, $id)
	{
		try{
			$course = $this->getEntityManager()->getRepository('\Rendes\Modules\Courses\Entities\Course')->getByID($courseID);
			$teacher = $this->getEntityManager()->getRepository('\Rendes\Modules\User\Entities\Teacher')->getByID($id);
		}catch(\Exception $e){
			throw new \CHttpException(404, 'Such course does not exist');
		}

		$teacherService = new \Rendes\Modules\User\Services\TeacherService();

		$teacher = $teacherService->unassign($teacher, $course);
		$this->getEntityManager()->flush();

		$this->redirect(array('/lms/courses/default/view','id' => $courseID));

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
