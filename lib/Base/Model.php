<?php

namespace Lib\Base;

use Lib\Database as Db;

class Model
{

    protected static $table;

    /**
     * table
     *
     * @var mixed
     */
    // protected $table;

    public function __construct()
    {
        $this->setTableColumns();

        return $this;
    }

    /**
     * Sets the database table the model is using
     * @param string $table the table the model is using
     */
    protected function setTable($table)
    {
        static::$table = $table;
    }

    protected function setTableColumns()
    {
        $columns = Db::getInstance()->getColumns(static::$table);
        foreach ($columns as $column) {
            $this->{$column->Field} = null;
        }
    }

    public static function find($params = [])
    {
        $results = [];
        $resultsQuery = Db::getInstance()->find(static::$table, $params);
        if ($resultsQuery) {
            foreach ($resultsQuery as $result) {
                $obj = new static();
                $obj->populateObject($result);
                $results[] = $obj;
            }
        }
        return $results;
    }

    public static function findFirst($params = [])
    {
        $resultsQuery = Db::getInstance()->findFirst(static::$table, $params);
        $result = new static();
        if ($result) {
            $result->populateObject($resultsQuery);
        }

        return $result;
    }

    public static function findById($id)
    {
        return self::findFirst(['conditions' => 'id = ?', 'bind' => [$id]]);
    }


    public static function insert($fields)
    {
        return Db::getInstance()->insert(static::$table, $fields);
    }

    public static function update($id, $fields)
    {
        return Db::getInstance()->update(static::$table, $id, $fields);
    }

    public static function delete($id)
    {
        return Db::getInstance()->delete(static::$table, $id);
    }

    public function getColumns()
    {
        return Db::getInstance()->getColumns(static::$table);
    }

    protected function populateObject($result)
    {
        foreach ($result as $key => $val) {
            $this->$key = $val;
        }
    }
}
