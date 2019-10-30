<?php
/**
 * Created by PhpStorm.
 * User: Админ
 * Date: 29.10.2019
 * Time: 23:29
 */

namespace App\models;


class User extends Model
{
    public $russianColumns = [
        'organizationName',
        'organizationAddress',
        'bank'
    ];

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setTableName('users');
    }

}