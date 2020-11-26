<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 24/10/2019
 * Time: 19:16
 */
require_once('config.php');
require_once('class.Format.php');

class Database extends Format
{
    public $connection;
    public $error = array();
    public $lastInsertedId= null;
    public function __construct()
    {
        parent::__construct();
        try {
            $this->conn();
        } catch (Exception $e) {
            //echo "Your exception handling" . $e;
        }
    }

    public function __destruct()
    {
        mysqli_close($this->connection);
    }

    public function conn()
    {
        $this->connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (!$this->connection) {
            $e = 'Failed to connect to DB';
            $this->setError($e);
            //echo "Your exception handling" . $e;
            return false;
        }
        return $this->connection;
    }

    protected function setError($error)
    {
        array_push($this->error, $error);
    }

    public function getError()
    {
        return $this->error;
    }

    public function getLastError()
    {
        return $this->error[count($this->error) - 1];
    }
    protected function Query($query)
    {

        if ($this->CheckConnection() === false) {
            return false;
        }
        $execute = mysqli_query($this->connection, $query);
        if (!$execute) {
            $e = 'MySQL query error ' . mysqli_error($this->connection);
            $this->setError($e);
            //echo "Your exception handling" . $e;
        }
        return $execute;
    }

    protected function CheckConnection()
    {
        if (!$this->connection) {
            $e = 'DB connection failed';
            $this->setError($e);
            //echo "Your exception handling" . $e;
            return false;
        }
        return true;
    }

    public function Execute($query)
    {
        if ($this->CheckConnection() === false) {
            return false;
        }
        $return = array();

        $execute = $this->Query($query);
        if ($execute === false) {
            $e = 'MySQL query error ' . mysqli_error($this->connection);
            $this->setError($e);
            //echo "Your exception handling" . $e;
            return ["error"=>$this->getLastError()];
        }
        if (!is_bool($execute)) {
            while ($row = mysqli_fetch_array($execute)) {
                $return[] = $row;
            }
        }

        return $return;
    }

    public function Select($table, $rows = "*", $where = "", $join = "", $sort = "", $order = " ASC ")
    {
        $query = "SELECT " . $rows . " FROM " . $table;
        if (!empty($join)) {
            $query .= ' JOIN ' . $join;
        }
        if (!empty($where)) {
            $query .= ' WHERE ' . $where;
        }
        if (!empty($sort)) {
            $query .= " ORDER BY " . $sort . " $order";
        }

        return $this->Execute($query);
    }

    public function Insert($table, array $rows)
    {
        $rows = $this->sqlWithArray($this->connection, $rows);
        $keys = "(" . implode(array_keys($rows), " ,") . ")";
        $values = " VALUES (" . implode(array_values($rows), ", ") . ")";
        $query = "INSERT INTO $table $keys $values";
        $response = $this->Execute($query);
        if (empty($response) and empty($this->getError())){
            return mysqli_insert_id($this->connection);
        }
        return $response;
    }

    public function Delete($table, $key = "", $values="")
    {

        $query = 'DELETE FROM ' . $table;
        if (!empty($key)) {
            $query .= ' WHERE ' . $key;
        }
        if (!empty($values)) {
            $query .= " in ('" . $values . "')";
        }
        return $this->Execute($query);

    }


}