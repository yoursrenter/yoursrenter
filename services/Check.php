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

    public static function translit($str)
    {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }
}