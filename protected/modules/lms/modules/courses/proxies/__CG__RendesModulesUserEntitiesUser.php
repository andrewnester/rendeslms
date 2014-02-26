<?php

namespace Proxies\__CG__\Rendes\Modules\User\Entities;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class User extends \Rendes\Modules\User\Entities\User implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    /** @private */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    
    public function rules()
    {
        $this->__load();
        return parent::rules();
    }

    public function setCreated($created)
    {
        $this->__load();
        return parent::setCreated($created);
    }

    public function getCreated()
    {
        $this->__load();
        return parent::getCreated();
    }

    public function setEmail($email)
    {
        $this->__load();
        return parent::setEmail($email);
    }

    public function getEmail()
    {
        $this->__load();
        return parent::getEmail();
    }

    public function setId($id)
    {
        $this->__load();
        return parent::setId($id);
    }

    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int) $this->_identifier["id"];
        }
        $this->__load();
        return parent::getId();
    }

    public function setModified($modified)
    {
        $this->__load();
        return parent::setModified($modified);
    }

    public function getModified()
    {
        $this->__load();
        return parent::getModified();
    }

    public function setName($name)
    {
        $this->__load();
        return parent::setName($name);
    }

    public function getName()
    {
        $this->__load();
        return parent::getName();
    }

    public function setPassword($password)
    {
        $this->__load();
        return parent::setPassword($password);
    }

    public function getPassword()
    {
        $this->__load();
        return parent::getPassword();
    }

    public function setRole($role)
    {
        $this->__load();
        return parent::setRole($role);
    }

    public function getRole()
    {
        $this->__load();
        return parent::getRole();
    }

    public function setCreationDate()
    {
        $this->__load();
        return parent::setCreationDate();
    }

    public function setModifiedDate()
    {
        $this->__load();
        return parent::setModifiedDate();
    }

    public function setAccessToken($accessToken)
    {
        $this->__load();
        return parent::setAccessToken($accessToken);
    }

    public function getAccessToken()
    {
        $this->__load();
        return parent::getAccessToken();
    }

    public function setRefreshToken($refreshToken)
    {
        $this->__load();
        return parent::setRefreshToken($refreshToken);
    }

    public function getRefreshToken()
    {
        $this->__load();
        return parent::getRefreshToken();
    }

    public function setTokenUpdated($tokenUpdated)
    {
        $this->__load();
        return parent::setTokenUpdated($tokenUpdated);
    }

    public function getTokenUpdated()
    {
        $this->__load();
        return parent::getTokenUpdated();
    }

    public function setExpires($expires)
    {
        $this->__load();
        return parent::setExpires($expires);
    }

    public function getExpires()
    {
        $this->__load();
        return parent::getExpires();
    }

    public function setActivateCode($activateCode)
    {
        $this->__load();
        return parent::setActivateCode($activateCode);
    }

    public function getActivateCode()
    {
        $this->__load();
        return parent::getActivateCode();
    }

    public function setActivated($activated)
    {
        $this->__load();
        return parent::setActivated($activated);
    }

    public function getActivated()
    {
        $this->__load();
        return parent::getActivated();
    }

    public function setPasswordRepeat($passwordRepeat)
    {
        $this->__load();
        return parent::setPasswordRepeat($passwordRepeat);
    }

    public function getPasswordRepeat()
    {
        $this->__load();
        return parent::getPasswordRepeat();
    }

    public function attributeNames()
    {
        $this->__load();
        return parent::attributeNames();
    }

    public function attributeLabels()
    {
        $this->__load();
        return parent::attributeLabels();
    }

    public function behaviors()
    {
        $this->__load();
        return parent::behaviors();
    }

    public function validate($attributes = NULL, $clearErrors = true)
    {
        $this->__load();
        return parent::validate($attributes, $clearErrors);
    }

    public function onAfterConstruct($event)
    {
        $this->__load();
        return parent::onAfterConstruct($event);
    }

    public function onBeforeValidate($event)
    {
        $this->__load();
        return parent::onBeforeValidate($event);
    }

    public function onAfterValidate($event)
    {
        $this->__load();
        return parent::onAfterValidate($event);
    }

    public function getValidatorList()
    {
        $this->__load();
        return parent::getValidatorList();
    }

    public function getValidators($attribute = NULL)
    {
        $this->__load();
        return parent::getValidators($attribute);
    }

    public function createValidators()
    {
        $this->__load();
        return parent::createValidators();
    }

    public function isAttributeRequired($attribute)
    {
        $this->__load();
        return parent::isAttributeRequired($attribute);
    }

    public function isAttributeSafe($attribute)
    {
        $this->__load();
        return parent::isAttributeSafe($attribute);
    }

    public function getAttributeLabel($attribute)
    {
        $this->__load();
        return parent::getAttributeLabel($attribute);
    }

    public function hasErrors($attribute = NULL)
    {
        $this->__load();
        return parent::hasErrors($attribute);
    }

    public function getErrors($attribute = NULL)
    {
        $this->__load();
        return parent::getErrors($attribute);
    }

    public function getError($attribute)
    {
        $this->__load();
        return parent::getError($attribute);
    }

    public function addError($attribute, $error)
    {
        $this->__load();
        return parent::addError($attribute, $error);
    }

    public function addErrors($errors)
    {
        $this->__load();
        return parent::addErrors($errors);
    }

    public function clearErrors($attribute = NULL)
    {
        $this->__load();
        return parent::clearErrors($attribute);
    }

    public function generateAttributeLabel($name)
    {
        $this->__load();
        return parent::generateAttributeLabel($name);
    }

    public function getAttributes($names = NULL)
    {
        $this->__load();
        return parent::getAttributes($names);
    }

    public function setAttributes($values, $safeOnly = true)
    {
        $this->__load();
        return parent::setAttributes($values, $safeOnly);
    }

    public function unsetAttributes($names = NULL)
    {
        $this->__load();
        return parent::unsetAttributes($names);
    }

    public function onUnsafeAttribute($name, $value)
    {
        $this->__load();
        return parent::onUnsafeAttribute($name, $value);
    }

    public function getScenario()
    {
        $this->__load();
        return parent::getScenario();
    }

    public function setScenario($value)
    {
        $this->__load();
        return parent::setScenario($value);
    }

    public function getSafeAttributeNames()
    {
        $this->__load();
        return parent::getSafeAttributeNames();
    }

    public function getIterator()
    {
        $this->__load();
        return parent::getIterator();
    }

    public function offsetExists($offset)
    {
        $this->__load();
        return parent::offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        $this->__load();
        return parent::offsetGet($offset);
    }

    public function offsetSet($offset, $item)
    {
        $this->__load();
        return parent::offsetSet($offset, $item);
    }

    public function offsetUnset($offset)
    {
        $this->__load();
        return parent::offsetUnset($offset);
    }

    public function __get($name)
    {
        $this->__load();
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        $this->__load();
        return parent::__set($name, $value);
    }

    public function __isset($name)
    {
        $this->__load();
        return parent::__isset($name);
    }

    public function __unset($name)
    {
        $this->__load();
        return parent::__unset($name);
    }

    public function __call($name, $parameters)
    {
        $this->__load();
        return parent::__call($name, $parameters);
    }

    public function asa($behavior)
    {
        $this->__load();
        return parent::asa($behavior);
    }

    public function attachBehaviors($behaviors)
    {
        $this->__load();
        return parent::attachBehaviors($behaviors);
    }

    public function detachBehaviors()
    {
        $this->__load();
        return parent::detachBehaviors();
    }

    public function attachBehavior($name, $behavior)
    {
        $this->__load();
        return parent::attachBehavior($name, $behavior);
    }

    public function detachBehavior($name)
    {
        $this->__load();
        return parent::detachBehavior($name);
    }

    public function enableBehaviors()
    {
        $this->__load();
        return parent::enableBehaviors();
    }

    public function disableBehaviors()
    {
        $this->__load();
        return parent::disableBehaviors();
    }

    public function enableBehavior($name)
    {
        $this->__load();
        return parent::enableBehavior($name);
    }

    public function disableBehavior($name)
    {
        $this->__load();
        return parent::disableBehavior($name);
    }

    public function hasProperty($name)
    {
        $this->__load();
        return parent::hasProperty($name);
    }

    public function canGetProperty($name)
    {
        $this->__load();
        return parent::canGetProperty($name);
    }

    public function canSetProperty($name)
    {
        $this->__load();
        return parent::canSetProperty($name);
    }

    public function hasEvent($name)
    {
        $this->__load();
        return parent::hasEvent($name);
    }

    public function hasEventHandler($name)
    {
        $this->__load();
        return parent::hasEventHandler($name);
    }

    public function getEventHandlers($name)
    {
        $this->__load();
        return parent::getEventHandlers($name);
    }

    public function attachEventHandler($name, $handler)
    {
        $this->__load();
        return parent::attachEventHandler($name, $handler);
    }

    public function detachEventHandler($name, $handler)
    {
        $this->__load();
        return parent::detachEventHandler($name, $handler);
    }

    public function raiseEvent($name, $event)
    {
        $this->__load();
        return parent::raiseEvent($name, $event);
    }

    public function evaluateExpression($_expression_, $_data_ = array (
))
    {
        $this->__load();
        return parent::evaluateExpression($_expression_, $_data_);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'name', 'password', 'email', 'role', 'activated', 'activateCode', 'accessToken', 'refreshToken', 'expires', 'tokenUpdated', 'created', 'modified');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields as $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}