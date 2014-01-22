<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

namespace Rendes\Modules\User\Components;

class WebUserIdentity extends \CUserIdentity
{
    protected $_id;

    /**
     * @return bool
     */
    public function authenticate(){
        $em = \Yii::app()->controller->module->doctrine->getEntityManager();
        $userRepository = $em->getRepository('Rendes\Modules\User\Entities\User');
        $user = $userRepository->findOneBy(array('name' => strtolower($this->username)));

        if((!is_object($user)) || (sha1(md5($this->password)) !== $user->password)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            $this->_id = $user->id;
            $this->username = $user->name;
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId(){
        return $this->_id;
    }
}