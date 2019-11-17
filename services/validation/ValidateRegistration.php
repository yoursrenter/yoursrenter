<?php

namespace App\services\validation;


class ValidateRegistration
{
    public function __construct()
    {
        // проверка правильности введенных полей (соответствие критериям)
        // запрос на уникальные поля - чтобы не создавать повторяющиеся (email)
        // запрос на создание новой записи в таблице
        return true;
    }
}