<?php
require_once 'mysql.class.php';


class DBHandler {

    protected $conn;

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    public function __construct(){
        $this->connect();
    }

    private function connect(){
        $user = 'root';
        $password = 'root';
        $dbname = 'wlwy';
        $host = 'localhost';

        // Create connection
        $this->conn = mysqli_connect($host, $user, $password, $dbname);

        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    }

    private function fetchToArray($query){
        $result=mysqli_query($this->conn, $query);
        $results = [];
        while ($row = $result->fetch_assoc()) {
            array_push($results, $row);
        }
        return $results;
    }

    public function retrieveObjects($objectName, $params = NULL, $args = NULL){
        $query = $this->constructSelect($objectName, $params, $args);
        return $this->fetchToArray($query);
    }

    private function constructSelect($objectName, $params, $args){
        //TODO: implement args
        $queryString = "SELECT " . $this->appendQueryParameters($params);
        return $queryString . " FROM " . strtolower($objectName);
    }

    private function appendQueryParameters($params){
        $paramString = "*";
        if(isset($params)) {
            $paramString = "";
            $i = 0;
            $len = count($params);
            foreach ($params as $param) {
                $paramString = $paramString . $param;
                if ($i == $len - 1) {
                    $paramString = $paramString . ", ";
                }
                $i++;
            }
        }
        return $paramString;
    }

}