<?php

namespace Lib;

use \PDO;
use \PDOException;


/**
 * Database Wrapper
 */
final class Database
{
    private static $instance;

    /**
     * connection: database connection
     *
     * @var mixed
     */
    private $connection;

    /**
     * _query: current query
     *
     * @var mixed
     */
    private $_query;

    /**
     * _count : row affected
     *
     * @var mixed
     */
    private $_count;

    /**
     * _result: result of query opperations
     *
     * @var mixed
     */
    private $_result;

    /**
     * _error:  database error
     *
     * @var mixed
     */
    private $_error;

    /**
     * _last_id: last affected id 
     *
     * @var integer
     */
    private $_last_id;


    /**
     * getInstance: Check if instance exists and return instance of database 
     *
     * @return Database
     */
    public static function getInstance(): Database
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * __construct:  Initialize database connection
     *
     * @return void
     */
    private function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD, [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
            ]);
        } catch (PDOException $e) {

            die("The following error has occured:" . $e->getMessage());
        }
    }

    /**
     * query: Main function for opperating with dataabase query
     *
     * @param  mixed $sql
     * @param  mixed $params
     * @return Database
     */
    public function query($sql, $params = []): Database
    {
        $this->_error = false;

        if ($this->_query = $this->connection->prepare($sql)) {

            if (count($params) > 0) {
                $x = 1;
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }


            if ($this->_query->execute()) {
                $this->_result = $this->_query->columnCount() > 0 ? $this->_query->fetchALL(PDO::FETCH_OBJ) : true;
                $this->_count = $this->_query->rowCount();
                $this->_last_id = $this->connection->lastInsertId();
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }

    /**
     * read: Abbstraction for select method
     *
     * @param  mixed $table
     * @param  mixed $params
     * @return void
     */
    protected function read($table, $params)
    {
        $conditionString = '';
        $bind = [];
        $order = '';
        $limit = '';

        // conditions

        if (isset($params['conditions'])) {
            if (is_array($params['conditions'])) {
                foreach ($params['conditions'] as $condition) {
                    $conditionString .= ' ' . $condition . ' AND';
                }
                $conditionString  = trim($conditionString);
                $conditionString = rtrim($conditionString, ' AND');
            } else {
                $conditionString = $params['conditions'];
            }
            if ($conditionString != '') {
                $conditionString = ' WHERE ' . $conditionString;
            }
        }


        // Bind

        if (array_key_exists('bind', $params)) {
            $bind = $params['bind'];
        }

        // Order

        if (array_key_exists('order', $params)) {
            $order = ' ORDER BY ' . $params['order'];
        }


        // Limit
        if (array_key_exists('limit', $params)) {
            $limit = ' LIMIT ' . $params['limit'];
        }

        $sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}";

        if ($this->query($sql, $bind)) {
            if (!(count($this->_result))) return false;
            return true;
        }
        return false;
    }

    /**
     * find: Find item in database
     *
     * @param  mixed $table
     * @param  mixed $params
     * @return void
     */
    public function find($table, $params = [])
    {
        if ($this->read($table, $params)) {
            return $this->result();
        }
        return false;
    }


    /**
     * findFirst: return only first from record list
     *
     * @param  mixed $table
     * @param  mixed $params
     * @return void
     */
    public function findFirst($table, $params = [])
    {
        if ($this->read($table, $params)) {
            return $this->first();
        }
        return false;
    }


    /**
     * insert: insert item in database
     *
     * @param  mixed $table
     * @param  mixed $fields
     * @return bool
     */
    public function insert($table, $fields = []): bool
    {
        $fieldString = '';
        $valueString = '';
        $values = [];

        foreach ($fields as $field => $value) {
            $fieldString .= '`' . $field . '`,';
            $valueString .= '?,';
            $values[] = $value;
        }

        $fieldString = rtrim($fieldString, ',');
        $valueString = rtrim($valueString, ',');

        $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";

        if (!$this->query($sql, $values)->error()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * update: update item in database
     *
     * @param  mixed $table
     * @param  mixed $id
     * @param  mixed $fields
     * @return void
     */
    public function update($table, $id, $fields = [])
    {
        $fieldString = '';

        foreach ($fields as $field => $value) {
            $fieldString .= ' ' . $field . ' = ?,';
        }

        $fieldString = trim($fieldString);
        $fieldString = rtrim($fieldString, ',');

        $sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";

        if (!$this->query($sql, array_values($fields))->error()) {
            return true;
        }
        return false;
    }

    /**
     * delete: delete item from database
     *
     * @param  mixed $table
     * @param  mixed $id
     * @return void
     */
    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id = {$id}";
        if (!$this->query($sql)->error()) {
            return true;
        }
        return false;
    }
    
    /**
     * first
     *
     * @return void
     */
    public function first()
    {
        return (!empty($this->_result)) ? $this->_result[0] : [];
    }
    
    /**
     * count
     *
     * @return void
     */
    public function count()
    {
        return $this->_count;
    }

    
    /**
     * result
     *
     * @return void
     */
    public function result()
    {
        return $this->_result;
    }
    
    /**
     * lastId
     *
     * @return void
     */
    public function lastId()
    {
        return $this->_last_id;
    }
    
    /**
     * error
     *
     * @return void
     */
    public function error()
    {
        return $this->_error;
    }
    
    /**
     * getColumns
     *
     * @param  mixed $table
     * @return void
     */
    public function getColumns($table)
    {
        return $this->query("SHOW COLUMNS FROM {$table}")->result();
    }

    /**
     * Disable the cloning of this class.
     * 
     * @return void
     */
    final public function __clone()
    {
        throw new \Exception('Feature disabled.');
    }

    /**
     * Disable the wakeup of this class.
     * 
     * @return void
     */
    final public function __wakeup()
    {
        throw new \Exception('Feature disabled.');
    }
}
