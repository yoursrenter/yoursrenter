<?php

namespace App\traits;

trait TSingleton
{
    private static $items;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    protected function __wakeup()
    {
    }

    /**
     * Создание одного единственного экземпляра класса
     * @return mixed
     */
    public static function getInstance()
    {
        if (empty(static::$items)) {
            static::$items = new static();
        }
        return static::$items;
    }
}
