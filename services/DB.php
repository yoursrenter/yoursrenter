<?php

namespace App\services;

use App\models\Model;
use App\traits\TSingleton;
use PDO;

class DB implements IDB
{
    private $config;
    private $DBName;

    use TSingleton;

    /**
     * метод получения конфигурационных данных для подключения к базе данных
     * @return void массив из файла конфигурации
     */
    protected function getConfig()
    {
        $this->config = include __DIR__ . '\..\config\config_default.php';
        $this->DBName = $this->config['db'];
    }

    public static function getDBName()
    {
        $config = include __DIR__ . '\..\config\config_default.php';
        return $config['db'];
    }

    /**
     * метод получения имен таблиц из базы данных определенной в файле конфигурации
     * @return array массив имен таблиц базы данных
     */
    public static function getTableNames()
    {
        $result = [];
        $config = include __DIR__ . '\..\config\config_default.php';
        $dsn = sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            $config['driver'],
            $config['host'],
            $config['db'],
            $config['charset']
        );
        $connect = new \PDO(
            $dsn,
            $config['user'],
            $config['pass']
        );
//        $sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '{$config['db']}'";
        $sql = "SHOW tables";
        $PDOStatement = $connect->prepare($sql);
        $PDOStatement->execute();
        $arr = $PDOStatement->fetchAll();
        foreach ($arr as $item => $value) {
//            $result[] = $item['table_name'];
            $result[] = $value[0];
        }
        return $result;
    }

    /**
     * метод получения последнего вставленного в таблицу базы данных id
     * @return string id
     */
    public function lastInsertId()
    {
        return $this->getConnect()->lastInsertId();
    }

    /**
     * @var \PDO|null
     */
    protected $connect = null;

    /**
     * Возвращает только один коннект с базой - объект PDO
     * @return \PDO|null
     */
    protected function getConnect()
    {
        if (empty($this->connect)) {
            $this->getConfig();
            $this->connect = new \PDO(
                $this->getDSN(),
                $this->config['user'],
                $this->config['pass']
            );
            $this->connect->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC
            );
        }
        return $this->connect;
    }

    /**
     * Создание строки - настройки для подключения
     * @return string
     */
    private function getDSN()
    {
        $this->getConfig();
        //'mysql:host=localhost;dbname=DB;charset=UTF8'
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            $this->config['driver'],
            $this->config['host'],
            $this->config['db'],
            $this->config['charset']
        );
    }

    /**
     * Выполнение запроса
     *
     * @param string $sql 'SELECT * FROM users WHERE id = :id'
     * @param array $params [':id' => 123]
     * @return \PDOStatement
     */
    private function query($sql, array $params = [])
    {
        $PDOStatement = $this->getConnect()->prepare($sql);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

    /**
     * Получение одного объекта
     *
     * @param string $sql
     * @param array $params
     * @return array|mixed
     */
    public function queryObject(string $sql, $class, array $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(
            \PDO::FETCH_CLASS,
            $class);
        return $PDOStatement->fetch();
    }

    /**
     * Получение в виде объектов
     *
     * @param string $sql
     * @param array $params
     * @return array|mixed
     */
    public function queryObjects(string $sql, $class, array $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(
            \PDO::FETCH_CLASS,
            $class);
        return $PDOStatement->fetchALL();
    }

    /**
     * Получение одной строки
     *
     * @param string $sql
     * @param array $params
     * @return array|mixed
     */
    public function find(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * Получение всех строк
     *
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function findAll(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Выполнение безответного запроса
     *
     * @param string $sql
     * @param array $params
     */
    public function execute(string $sql, array $params = [])
    {
        $this->query($sql, $params);
    }

    public function getAll(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function getOne(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * метод получения всех свойств из базы данных
     */
    public function getProperties($tableName)
    {
        $result = [];
        $sql = "SHOW COLUMNS FROM {$tableName}";
        $arr = DB::getInstance()->getAll($sql);
        foreach ($arr as $item) {
            $result[] = $item['Field'];
        }
        return $result;
    }

    /**
     * метод получения всех unit-данных в виде массива
     */
    public static function getUnitsAllTables()
    {
        $units = [];
        $tableNames = DB::getTableNames();
        foreach ($tableNames as $tableName) {
            $ClassNames = DB::getClassFromTableNames($tableName);
//            $prop = DB::getMainProperty($ClassNames['nameFull']);
            $sql = "SELECT * FROM {$tableName}";
            $arr = DB::getInstance()->getAll($sql);
            foreach ($arr as $item) {
                $units[$tableName][] = [
                    'actionOne' => strtolower($ClassNames['nameShort']),
                    'prop' => $item[$prop],
                    'id' => $item['id']
                ];
            }
        }
        return $units;
    }

    /**
     * метод получения важного свойства
     * @param $ClassName
     * @return mixed
     */
    public static function getMainProperty($ClassName)
    {
        $result = (new $ClassName())->getKeyProperty();
        return $result;
    }

    /**
     * метод получения названия класса из имени таблицы из базы данных
     * @param $tableNames
     * @return string
     */
    public static function getClassFromTableNames($tableNames)
    {
        $str = $tableNames;
        if ($str[mb_strlen($str) - 1] === 's') {
            $str = mb_substr($str, 0, mb_strlen($str) - 1);
        }
        $ClassName = ucfirst($str);
        $ClassNameFull = 'App\\models\\' . $ClassName;
        return [
            'nameShort' => $ClassName,
            'nameFull' => $ClassNameFull
        ];
    }
}
