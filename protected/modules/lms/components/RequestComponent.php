<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 23.11.13
 * Time: 23:27
 * To change this template use File | Settings | File Templates.
 */

namespace Rendes\Components;

class RequestComponent extends \CComponent
{
    private $codes = array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
    );

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
}