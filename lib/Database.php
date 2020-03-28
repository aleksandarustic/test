<?php

namespace Lib;

use \PDO;
use \PDOException;


final class Database
{
    private static $instance;

    private $connection;

    private $_query;
    private $_count;
    private $_result;
    private $_error;
    private $_last_id;


    /**
     * __construct
     *
     * @return void
     */

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

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

    public function query($sql, $params = [])
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

    public function find($table, $params = [])
    {
        if ($this->read($table, $params)) {
            return $this->result();
        }
        return false;
    }


    public function findFirst($table, $params = [])
    {
        if ($this->read($table, $params)) {
            return $this->first();
        }
        return false;
    }


    /**
     * insert
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

    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id = {$id}";
        if (!$this->query($sql)->error()) {
            return true;
        }
        return false;
    }

    public function first()
    {
        return (!empty($this->_result)) ? $this->_result[0] : [];
    }

    public function count()
    {
        return $this->_count;
    }


    public function result()
    {
        return $this->_result;
    }

    public function lastId()
    {
        return $this->_last_id;
    }

    public function error()
    {
        return $this->_error;
    }

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
