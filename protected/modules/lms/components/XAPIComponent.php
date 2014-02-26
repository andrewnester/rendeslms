<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 23.11.13
 * Time: 23:27
 * To change this template use File | Settings | File Templates.
 */

namespace Rendes\Components;

class XAPIComponent extends \CComponent
{
    private $baseUrl;
    private $clientID;
    private $clientSecret;
    private $entityManager;

    public function init()
    {

    }

    public function authenticate()
    {
        $user = $this->getUser();
        if($user->isGuest){
            throw new \CHttpException(403, 'Forbidden! You need to log in first');
        }

        $user = $user->getEntity();
        if(!$user->getAccessToken()){
            if(!$user->getRefreshToken()){
                $this->requestTokens($user);
            }else{
                $this->refreshTokens($user);
            }
        }
    }

    /**
     * @param array $searchOptions
     * @return bool|mixed
     */
    public function getStatements($searchOptions = array())
    {
        $this->authenticate();

        $http = $this->getHttpClientComponent();
        $user = $this->getUser()->getEntity();

        $jsonResponse = $http->sendGet($this->getBaseUrl() . 'statements', $searchOptions, array('Authorization: Bearer ' . $user->getAccessToken()));
        if($jsonResponse === false){
            throw new \CHttpException(500, 'Internal server error');
        }

        $status = $http->getStatus();
        if($status != 200){
            throw new \CHttpException($status, 'LRS Connection:' . $http->getStatusMessage($status));
        }

        $jsonResponse = $http->sendGet($this->getBaseUrl() . 'statements', $searchOptions, array('Authorization: Bearer ' . $user->getAccessToken()));
        if($jsonResponse === false){
            throw new \CHttpException(500, 'Internal server error');
        }

        return json_decode($jsonResponse);
    }

    /**
     * @param array $statement
     */
    public function putStatement($statement)
    {
        $this->authenticate();
        $user = $this->getUser()->getEntity();

        if(!isset($statement['id'])){
            return false;
        }

        $http = $this->getHttpClientComponent();
        $http->sendPut($this->getBaseUrl() . 'statements?statementId='.$statement['id'], $statement, true,  array('Authorization: Bearer ' . $user->getAccessToken()));

        $status = $http->getStatus();
        if($status != 200){
            throw new \CHttpException($status, 'LRS Connection:' . $http->getStatusMessage($status));
        }

        return true;
    }

    /**
     * @param array $statement
     */
    public function postStatement($statement)
    {
        $this->authenticate();
        $user = $this->getUser()->getEntity();

        $http = $this->getHttpClientComponent();
        $http->sendPost($this->getBaseUrl() . 'statements', $statement, true,  array('Authorization: Bearer ' . $user->getAccessToken()));

        $status = $http->getStatus();
        if($status != 200){
            throw new \CHttpException($status, 'LRS Connection:' . $http->getStatusMessage($status));
        }

        return true;
    }



    public function registerUser(\Rendes\Modules\User\Entities\User $user)
    {
        $http = $this->getHttpClientComponent();
        $registerUser = array(
            'username' => $user->getName(),
            'password' => $user->getPassword(),
            'clientId' => $this->getClientID(),
        );
        $http->sendPost($this->getBaseUrl() . 'users/register', $registerUser);

        $status = $http->getStatus();
        if($status != 200){
            throw new \CHttpException($status, 'LRS Connection:' . $http->getStatusMessage($status));
        }

        $this->requestTokens($user);
        return true;
    }


    /**
     * @param \Rendes\Modules\User\Entities\User $user
     * @throws \CHttpException
     */
    private function requestTokens(\Rendes\Modules\User\Entities\User $user)
    {
        $http = $this->getHttpClientComponent();

        $jsonResponse = $http->sendPost($this->getBaseUrl() . 'oauth/token', array(
            'grant_type' => 'password',
            'client_id' => $this->getClientID(),
            'client_secret' => $this->getClientSecret(),
            'username' => $user->getName(),
            'password' => $user->getPassword()
        ), false);

        $status = $http->getStatus();
        if($status != 200){
            throw new \CHttpException($status, $http->getStatusMessage($status));
        }

        $tokens = json_decode($jsonResponse);
        $user = $this->populateUserTokens($user, $tokens);

        $em = $this->getEntityManager();
        $em->flush();
    }

    /**
     * @throws \CHttpException
     */
    private function refreshTokens(\Rendes\Modules\User\Entities\User $user)
    {
        $http = $this->getHttpClientComponent();

        $jsonResponse = $http->sendPost($this->getBaseUrl() . 'oauth/token', array(
            'grant_type' => 'refresh_token',
            'client_id' => $this->getClientID(),
            'client_secret' => $this->getClientSecret(),
            'refresh_token' => $user->getRefreshToken(),
        ), false);

        $status = $http->getStatus();
        if($status != 200){
            throw new \CHttpException($status, $http->getStatusMessage($status));
        }

        $tokens = json_decode($jsonResponse);
        $user = $this->populateUserTokens($user, $tokens);

        $em = $this->getEntityManager();
        $em->flush();
    }

    /**
     * @param \Rendes\Modules\User\Entities\User $user
     * @param object $tokens
     * @return \Rendes\Modules\User\Entities\User
     */
    private function populateUserTokens($user, $tokens)
    {
        $user->setAccessToken($tokens->access_token);
        $user->setRefreshToken($tokens->refresh_token);
        $user->setExpires($tokens->expires_in);
        $user->setTokenUpdated(new \DateTime());
        return $user;
    }





    /**
     * @return \Rendes\Components\HttpClientComponent
     */
    protected function getHttpClientComponent()
    {
        return \Yii::app()->getModule('lms')->http;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        if(is_null($this->entityManager)){
            $this->entityManager = \Yii::app()->controller->module->doctrine->getEntityManager();
        }
        return $this->entityManager;
    }

    /**
     * @return \Rendes\Modules\User\Components\WebUser
     */
    protected function getUser()
    {
        return \Yii::app()->getModule('lms')->getModule('user')->user;
    }




    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function setClientID($clientID)
    {
        $this->clientID = $clientID;
    }

    public function getClientID()
    {
        return $this->clientID;
    }

    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

}