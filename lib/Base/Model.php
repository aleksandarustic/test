<?php

namespace Lib\Base;

use Lib\Database as Db;

/**
 * This is base controller of app
 */
class Model
{

    protected static $table;


    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->setTableColumns();
    }

    /**
     * Sets the database table the model is using
     * @param string $table the table the model is using
     */
    protected function setTable($table)
    {
        static::$table = $table;
    }


    /**
     * Gets available columns for madel from
     * 
     * @return void
     */
    protected function setTableColumns()
    {
        $columns = Db::getInstance()->getColumns(static::$table);
        foreach ($columns as $column) {
            $this->{$column->Field} = null;
        }
    }


    /**
     * finds all items from database for required conditions
     *
     * @param  mixed $params
     * @return Array
     */
    public static function find($params = []): array
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


    /**
     * Return instance of Model for required conditions
     *
     * @param  mixed $params
     * @return Model
     */
    public static function findFirst($params = []): Model
    {
        $resultsQuery = Db::getInstance()->findFirst(static::$table, $params);
        $result = new static();
        if ($result) {
            $result->populateObject($resultsQuery);
        }

        return $result;
    }

    /**
     * Find instance by iid
     *
     * @param  integer $id
     * @return Model
     */
    public static function findById($id): Model
    {
        return self::findFirst(['conditions' => 'id = ?', 'bind' => [$id]]);
    }


    /**
     * insert record into database
     *
     * @param  mixed $fields
     * @return bool
     */
    public static function insert($fields): bool
    {
        return Db::getInstance()->insert(static::$table, $fields);
    }

    /**
     * update record in database
     *
     * @param  mixed $id
     * @param  mixed $fields
     * @return mixed
     */
    public static function update($id, $fields)
    {
        return Db::getInstance()->update(static::$table, $id, $fields);
    }

    /**
     * delete item from database
     *
     * @param  mixed $id
     * @return mixed
     */
    public static function delete($id)
    {
        return Db::getInstance()->delete(static::$table, $id);
    }

    /**
     * get abailable columns from database
     *
     * @return void
     */
    public function getColumns()
    {
        return Db::getInstance()->getColumns(static::$table);
    }

    /**
     * fill instance with attribues
     *
     * @param  mixed $result
     * @return void
     */
    protected function populateObject($result)
    {
        foreach ($result as $key => $val) {
            $this->$key = $val;
        }
    }
}
