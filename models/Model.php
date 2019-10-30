<?php

namespace App\models;

use App\services\Check;
use App\services\DB;
use App\services\IDB;
use App\traits\TSingleton;

class Model
{
    /**
     * @var DB Класс для работы с базой данных
     * @method static User($id)
     */
    protected $db;
    private $tableName;

    private $data;

    use TSingleton;

    /**
     * Model constructor.
     */
    public function __construct($data = [])
    {
        $this->data = $data;
        $this->db = DB::getInstance();
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        $this->properties = $this->getProperties();
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * метод проверки свойств модели
     * @param $prop
     * @return bool
     */
    public function isProperty($prop)
    {
        return in_array($prop, $this->properties);
    }

    public function setData($data)
    {
        $this->toValidateData($data);
        $this->data = $data;
    }

    /**
     * метод для приведения к допустимому для базы данных виду (русские буквы не разрешены)
     * @param $data
     */
    public function toValidateData(&$data)
    {
        $arr = $this->russianColumns;
        if (!$arr) {
            return;
        }
        foreach ($data as $key => $value) {
            if (in_array($key, $arr) && $this->isRussianText($value)) {
                $data[$key] = Check::translit($value);
                var_dump($this);
//                $this->russianColumns[] = $key;
                // записать в базу данных (поле russianColumns) что $key - русская колонка
            }
        }
        var_dump($data);
    }
    public function isRussianText($text){return true;}

    /**
     * Возращает запись с указанным id
     *
     * @param int $id ID Записи таблицы
     * @return array
     */
    public function getOne($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return DB::getInstance()->queryObject($sql, get_called_class(), [':id' => $id]);
    }

    /**
     * возвращает все записи таблицы базы данных
     * @param $id
     * @return mixed
     */
    public function getAll()
    {
        $tableName = $this->tableName;
        $sql = "SELECT * FROM {$tableName}";
        return DB::getInstance()->queryObjects($sql, get_called_class());
    }

    /**
     * получить данные по всем id в виде массива
     * @return mixed
     */
    public function readAll()
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return DB::getInstance()->getAll($sql);
    }

    public function findOne($prop, $value)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE {$prop}=:{$prop}";
        return DB::getInstance()->getOne($sql, [':' . $prop => $value]);
    }

    /**
     * получить данные по id в виде массива
     * @param $id
     * @return mixed
     */
    public function readOne($id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id=:id";
        return DB::getInstance()->getOne($sql, [':id' => $id]);
    }

    /**
     * метод вставки данных в таблицу
     */
    public function insert()
    {
        $columns = [];
        $params = [];
        foreach ($this->data as $key => $value) {
            if ($this->isProperty($key)) {
                $columns[] = "`" . $key . "`";
                $placeholdersArr[] = ":" . $key;
                $params[$key] = $value;
            }
        }
        $columnsStr = implode(', ', $columns);
        $placeholders = implode(', ', $placeholdersArr);

        $tableName = static::getTableName();
        $sql = "INSERT INTO `{$tableName}` ({$columnsStr}) VALUES ({$placeholders})";
        $this->db->execute($sql, $params);
    }

    /*
     * метод удаления данных по заранее заданному id
     */
    public function delete($params = [])
    {
        $tableName = static::getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id={$this->id}";
        $this->db->execute($sql, $params);
    }

    public function deleteOne($id)
    {
        $tableName = static::getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id={$id}";
        $this->db->execute($sql);
    }

    /**
     * метод обновления данных в таблице БД
     */
    public function update()
    {
        $params = [];
        $keyValueElems = [];
        foreach ($this->data as $key => $value) {
            if ($this->isProperty($key) && $key !== 'id') {
                $keyValueElems[] = "{$key}='{$value}'";
            }
        }
        $keyValueString = implode(', ', $keyValueElems);
        $tableName = static::getTableName();
        $sql = "UPDATE {$tableName} SET {$keyValueString} WHERE id = {$this->data['id']};";
        var_dump($sql);
        $this->db->execute($sql, $params);
    }

    /**
     * метод сохранения данных
     * в случае если id указан в данных - обновляет таблицу данных БД
     * если id не указан - добавляет последней строчкой в таблицу БД
     */
    public function save()
    {
        if (!$this->data['id']) {
            var_dump('****');
            $this->insert();
        } else {
            var_dump('&&&&&');
            $this->update();
        }
    }

    /**
     * метод получения всех свойств модели
     */
    public function getProperties()
    {
        return $this->db->getProperties($this->getTableName());
    }

    public static function getDBName()
    {
        return DB::getDBName();
    }

    public static function getTableNames()
    {
        return DB::getTableNames();
    }

}
