<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 20.11.13
 * Time: 23:00
 * To change this template use File | Settings | File Templates.
 */

namespace Rendes\Modules\User\Services;

class PasswordEncoder
{
    public function encode($password)
    {
        return sha1(md5($password));
    }
}