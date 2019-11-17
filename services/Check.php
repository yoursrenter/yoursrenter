<?php
/**
 * Created by PhpStorm.
 * User: Админ
 * Date: 30.10.2019
 * Time: 0:02
 */

namespace App\services;


use App\models\User;

class Check
{
    private $login;
    private $pass;
    private $user;

    public function __construct($loginParams)
    {
        $this->login = $loginParams['login'];
        $this->pass = $loginParams['pass'];
        $this->user = (new User())->findOne('login', $this->login);
    }

    public function run()
    {
        // проверка правильности логина
        if (!$this->user) {
            Session::setParam('errorLogin', 'login');
            return false;
        }
        // проверка правильности пароля
        if ($this->user['pass'] != $this->pass) {
            Session::setParam('errorLogin', 'pass');
            return false;
        }
        return true;
    }
}