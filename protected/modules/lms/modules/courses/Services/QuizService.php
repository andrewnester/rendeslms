<?php
/**
 * User: nester_a
 * Date: 22.01.14
 */

namespace Rendes\Modules\Courses\Services;
use \Rendes\Modules\Courses\Interfaces as Interfaces;

class QuizService extends CourseBaseService
{

    /**
     * @var Interfaces\ResultRepositories\ILectureResultRepository
     */
    private $repository = null;

    /**
     * @return Interfaces\ResultRepositories\IQuizResultRepository
     */
    public function getResultRepository()
    {
        if(is_null($this->repository)){
            $this->repository = $this->loadResultRepository('quiz');
        }
        return $this->repository;
    }

    public function populate(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\Courses\Entities\Step $step, $quizData)
    {
        $quiz->setName($quizData['name']);
        $quiz->setDescription($quizData['description']);

		$quiz->setAttributes($quizData, false);

        $widgets = $this->getAvailableWidgets();
        $widget = array();
        $widgetID = isset($quizData['widget_id']) ? $quizData['widget_id'] : null ;
        if(!empty($widgetID)){
            $widget[$widgetID]['classname'] = $widgets[$widgetID]['classname'];
            $widget[$widgetID]['options'] = isset($quizData['widget'][$widgetID]) ? $quizData['widget'][$widgetID] : array();
            $quiz->setWidget($widget);
        }

        $quiz->setStep($step);
        return $quiz;
    }

    /**
     * @return array
     */
    public function getAvailableTypes()
    {
		$quizTypes = \Yii::app()->getModule('lms')->getModule('courses')->params->quizTypes;
		$availableTypes = array();
		foreach($quizTypes as $quizType){
			$availableTypes[$quizType['class']] = $quizType['name'];
		}
		return $availableTypes;
    }

    /**
     * @return array
     */
    public function getAvailableWidgets()
    {
        $widgets = array();
        $pathToWidgetsDir = __DIR__ . '/../Widgets/Quiz/';
        $dir = opendir($pathToWidgetsDir);
        while (false !== ($entry = readdir($dir))) {
            if(strpos($entry, '.json') !== false){
                $configContent = file_get_contents($pathToWidgetsDir . $entry);
                $decoded = json_decode($configContent, true);
                $widgets[$decoded['id']] = $decoded;
            }
        }

        return $widgets;
    }

    /**
     * @param \Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz
     * @return mixed
     */
    public function getQuizWidget(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz)
    {
        $widget = array_shift(array_values($quiz->getWidget()));

        $properties = array(
            'quiz' => $quiz,
            'options' => $widget['options']
        );
        return \Yii::app()->getWidgetFactory()->createWidget($this, $widget['classname'], $properties);
    }

    /**
     * @param \Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz
     * @return array
     */
    public function getQuestionsOrder(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz)
    {
        $questions = $quiz->getQuestions();
        $quizOptions = $quiz->getOptions($quiz);

        $order = array();
        foreach($questions as $question){
            $order[] = $question->getId();
        }

        if(isset($quizOptions['random']) && $quizOptions['random']){
            shuffle($order);
        }

        return $order;
    }

	/**
	 * @param \Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz
	 * @return array
	 */
	public function generateTabs(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz)
	{
		$hashService = new \Rendes\Services\HashService();
		$widgets = $this->getAvailableWidgets();

		$tabs = array();
		foreach($this->getAvailableTypes() as $class => $type){
			$quizReflectionClass = new \ReflectionClass($class);
			$activeTab = $quiz instanceof $class;
			$tabs[$hashService->hash(trim($class, '\\'))] = array(
				'title' => $type,
				'view' => 'types/_'.strtolower($quizReflectionClass->getShortName()),
				'data' => array('model' => $activeTab ? $quiz : new $class(), 'widgets' => $widgets)
			);
		}

		return $tabs;
	}

    /**
     * @param \Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz
     * @param \Rendes\Modules\User\Entities\User $user
     * @return bool|mixed
     */
    public function getQuizResults(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user)
    {
        $xapi = $this->getXAPI();
        $searchOptions = array(
            'agent' => json_encode(array(
                'mbox' => $user->getEmail()
            )),
            'activity' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$quiz->getStep()->getCourse()->getId().'/steps/'.$quiz->getStep()->getId().'/quizzes/'.$quiz->getId()),
            'related_activities' => true
        );
        return $xapi->getStatements($searchOptions);
    }

    /**
     * @param \Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz
     * @param \Rendes\Modules\User\Entities\User $user
     * @return bool
     */
    public function isAvailableToStart(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user)
    {
		$validator = $this->getService('quizStartValidator');
		return $validator->validate($quiz, $user);
    }

    /**
     * @param \Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz
     * @param \Rendes\Modules\User\Entities\User $user
     * @return array
     */
    public function prepareAttemptStatement(\Rendes\Modules\Courses\Entities\Quiz\Quiz $quiz, \Rendes\Modules\User\Entities\User $user)
    {
        return array(
            'actor' => array(
                'mbox' => $user->getEmail()
            ),
            'verb' => array(
                'id' => 'http://adlnet.gov/expapi/verbs/attempted'
            ),
            'object' => array(
                'id' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$quiz->getStep()->getCourse()->getId().'/steps/'.$quiz->getStep()->getId().'/quizzes/'.$quiz->getId()),
                'definition' => array(
                    'name' => array(
                        'en-US' => $quiz->getName()
                    ),
                    'description' => array(
                        'en-US' => $quiz->getDescription())
                )
            ),
            'context' => array(
                'contextActivities' => array(
                    'grouping' => array(
                        'id' => \Yii::app()->createAbsoluteUrl('/lms/courses/'.$quiz->getStep()->getCourse()->getId().'/steps/'.$quiz->getStep()->getId()),
                    )
                )
            )
        );
    }

}