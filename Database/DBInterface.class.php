<?php
require_once 'DBOperator.class.php';

class DBHandler {

    private $dbOperator;

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    public function __construct(){
        $this->dbOperator = new DBOperator();
    }

    public function retrieveObjects($objectName, $columns=null, $filters=null){
        $sql = "SELECT " .
                       $this->appendColumns($columns) .
                       " FROM " .
                       strtolower($objectName) .
                       $this->appendFilters($filters);
        return $this->dbOperator->fetchToArray($sql);
    }

    public function retrieveObjectsBelongingTo($objectName, $params, $field_name, $owner){
        return $this->retrieveObjects($objectName, $params, [$field_name . " = " . $owner]);
    }

    public function insertObject($objectName, $inData){
        $columnString = implode(", ", array_keys($inData));
        $escaped_values = array_map('mysql_real_escape_string', array_values($inData));
        $values  = implode(", ", $escaped_values);
        $sql = "INSERT INTO ".$objectName."($columnString) VALUES ($values)";
        return $this->dbOperator->executeQuery($sql);
    }

    private function appendColumns($columns){
        $columnString = "*";
        if(isset($columns) || count($columns)>0) {
            $columnString  = implode(", ", $columns);
        }
        return $columnString;
    }

    private function appendFilters($filters){
        $filterString = "";
        if(isset($filters) || count($filters)>0) {
            $filterString  = " WHERE " .implode(" AND ", $filters);
        }
        return $filterString;
    }
}