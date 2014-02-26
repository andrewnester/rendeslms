<?php
/**
 * User: nester_a
 * Date: 25.02.14
 */

namespace Rendes\Validators;

class DoctrineUnique extends \CValidator
{
    /**
     * Validates a single attribute.
     * This method should be overridden by child classes.
     * @param \CModel $object the data object being validated
     * @param string $attribute the name of the attribute to be validated.
     */
    protected function validateAttribute($object, $attribute)
    {
        $methodName = 'get' . ucfirst($attribute);
        if(!method_exists($object, $methodName)){
            throw new \CException(\Yii::t('yii','Class "{class}" does not have a field named "{column}".',
                array('{column}' => $attribute,'{class}' => get_class($object))));
        }

        $entityManager = $this->getEntityManager();
        $value = $object->$methodName();
        $foundObject = $entityManager->getRepository('\Rendes\Modules\User\Entities\User')->findBy(array($attribute => $value));

        if($foundObject) {
            $message = $this->message !==null ? $this->message : \Yii::t('yii','{attribute} "{value}" has already been taken.');
            $this->addError($object,$attribute,$message,array('{value}' => \CHtml::encode($value)));
        }
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return \Yii::app()->getModule('lms')->doctrine->getEntityManager();
    }

}