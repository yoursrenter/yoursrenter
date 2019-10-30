<?php

class Autoload
{
    public function loadClass($className)
    {
        $file = str_replace(
            ['App\\', '\\'],
            [$_SERVER['DOCUMENT_ROOT'] ."/", '/'],
            $className
        ). '.php';
        if (file_exists($file)) {
            include $file;
        }
    }
}
