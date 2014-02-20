<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 23.11.13
 * Time: 23:27
 * To change this template use File | Settings | File Templates.
 */

namespace Rendes\Components;

class HttpClientComponent extends \CComponent
{
    private $codes = array(
        200 => 'OK',
        204 => 'No Content',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
    );

    private $responseStatus;

    public function init()
    {

    }

    public function getPost($name, $default = null)
    {
        return isset($_POST[$name]) ? $_POST[$name]  : $default;
    }

    public function getGet($name, $default = null)
    {
        return isset($_GET[$name]) ? $_GET[$name]  : $default;
    }

    public function get($name, $default = null)
    {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name]  : $default;
    }

    public function json($data, $status = 200)
    {
        header('HTTP/1.1 ' . $status . ' ' . $this->codes[$status]);
        header('Content-type: application/json');
        echo \CJSON::encode($data);
        \Yii::app()->end();
    }

    /**
     * @param string $url
     * @param array $data
     * @param bool $json
     * @return mixed
     */
    public function sendPost($url, $data, $json = true, $headers = array())
    {
        $postData = $json ? json_encode($data) : http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $this->responseStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return $response;
    }

    /**
     * @param string $url
     * @param array $data
     * @return mixed
     */
    public function sendGet($url, $data, $headers = array())
    {
        $url = $url . '?' . http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $this->responseStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return $response;
    }

    /**
     * @param string $url
     * @param array $data
     * @param bool $json
     * @return mixed
     */
    public function sendPut($url, $data, $json = true, $headers = array())
    {
        $putData = $json ? json_encode($data) : http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $putData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $this->responseStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return $response;
    }


    public function getStatus()
    {
        return $this->responseStatus;
    }

    public function getStatusMessage($status)
    {
        return isset($this->codes[$status]) ? $this->codes[$status] : 'Application error';
    }

}