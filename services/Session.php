<?php
/**
 * Created by PhpStorm.
 * User: Админ
 * Date: 30.10.2019
 * Time: 1:41
 */

namespace App\services;


use App\traits\TSingleton;

class Session
{
    use TSingleton;

    public static function setAuth($loginName)
    {
        session_start();
        $_SESSION['auth'] = [
            'name' => $loginName
        ];
    }

    public static function setParam($param, $value)
    {
        $_SESSION[$param] = $value;
    }

    public static function getParam($param)
    {
        return $_SESSION[$param];
    }

    public static function getAuth()
    {
        return $_SESSION['auth'];
    }

    public static function unsetAuth()
    {
        unset($_SESSION['auth']);
//        session_destroy();
    }
}