<?php
namespace App\services;

interface IDB
{
    public function find(string $sql, array $params = []);
    public function findAll(string $sql, array $params = []);
}