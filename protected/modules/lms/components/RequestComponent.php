<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 23.11.13
 * Time: 23:27
 * To change this template use File | Settings | File Templates.
 */

class RequestComponent extends CComponent
{
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
}