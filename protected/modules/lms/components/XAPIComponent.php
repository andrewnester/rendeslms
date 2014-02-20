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

    /**
     * @param array $searchOptions
     * @return bool|mixed
     */
    public function getStatements($searchOptions = array())
    {
        $http = $this->getHttpClientComponent();
        $user = $this->getUser()->getEntity();
        if(!$user->getAccessToken()){
            $this->requestTokens();
        }

        $jsonResponse = $http->sendGet($this->getBaseUrl() . 'statements', $searchOptions, array('Authorization: Bearer ' . $user->getAccessToken()));
        if($jsonResponse === false){
            throw new \CHttpException(500, 'Internal server error');
        }

        $status = $http->getStatus();
        if($status == 401){
            $this->refreshTokens();
        }

        $status = $http->getStatus();
        if($status != 200){
            throw new \CHttpException($status, $http->getStatusMessage($status));
        }

        $jsonResponse = $http->sendGet($this->getBaseUrl() . 'statements', $searchOptions, array('Authorization: Bearer ' . $user->getAccessToken()));
        if($jsonResponse === false){
            throw new \CHttpException(500, 'Internal server error');
        }

        return json_decode($jsonResponse);
    }

    public function requestTokens()
    {
        $http = $this->getHttpClientComponent();
        $user = $this->getUser()->getEntity();
        if(!$user){
            throw new \CHttpException(403, 'Forbidden! You need to log in first');
        }

        $jsonResponse = $http->sendPost($this->getBaseUrl() . 'oauth/token', array(
            'grant_type' => 'password',
            'client_id' => $this->getClientID(),
            'client_secret' => $this->getClientSecret(),
            'username' => $user->getName(),
            'password' => $user->getPassword()
        ), false);

        $tokens = json_decode($jsonResponse);
        $user->setAccessToken($tokens->access_token);
        $user->setRefreshToken($tokens->refresh_token);
        $em = $this->getEntityManager();
        $em->flush();
    }


    public function refreshTokens()
    {
        $http = $this->getHttpClientComponent();
        $user = $this->getUser()->getEntity();
        if(!$user){
            throw new \CHttpException(403, 'Forbidden! You need to log in first');
        }

        $jsonResponse = $http->sendPost($this->getBaseUrl() . 'oauth/token', array(
            'grant_type' => 'refresh_token',
            'client_id' => $this->getClientID(),
            'client_secret' => $this->getClientSecret(),
            'refresh_token' => $user->getRefreshToken(),
        ), false);

        $tokens = json_decode($jsonResponse);
        $user->setAccessToken($tokens->access_token);
        $user->setRefreshToken($tokens->refresh_token);
        $em = $this->getEntityManager();
        $em->flush();
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