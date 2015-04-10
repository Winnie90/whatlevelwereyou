<?php
require_once 'mysql.class.php';
include 'DevelopmentConfiguration.php';

class DBHandler {

    protected  $db;

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    public function __construct(){
        $this->db = new mysql('localhost', $DB_NAME, $DB_USERNAME, $DB_PASSWORD);
        $this->db->connect();
    }

    public function retrieveObjects($objectName, $params = NULL, $args = NULL){
        $query = $this->constructSelect($objectName, $params, $args);
        return $this->db->fetchToArray($query);
    }

    private function constructSelect($objectName, $params, $args){
        $queryString = "SELECT ";
        if(!isset($params)){
            $queryString = $queryString . "*";
        }

        return $queryString . "FROM " . $objectName;
    }

    public function disconnect(){
        $this->db->disconnect();
    }

}