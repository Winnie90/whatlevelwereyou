<?php

class DBOperator {

    protected $conn;

    public function __construct(){
        $this->connect();
    }

    private function connect(){
        $user = 'root';
        $password = 'root';
        $dbName = 'wlwy';
        $host = 'localhost';

        // Create connection
        $this->conn = mysqli_connect($host, $user, $password, $dbName);

        // Check connection
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    }

    public function fetchToArray($query){
        if(!$this->checkConnectivity())
            $this->connect();
        $result=mysqli_query($this->conn, $query);
        if(!$result){
            throw new Exception("Database Error [{$this->conn->errno}] {$this->conn->error} for {$query}");
        }
        $results = [];
        while ($row = $result->fetch_assoc()) {
            array_push($results, $row);
        }
        return $results;
    }

    public function executeQuery($query){
        if(!$this->checkConnectivity())
            $this->connect();
        mysqli_query($this->conn, $query);
        if(mysqli_insert_id($this->conn)!='') {
            return mysqli_insert_id($this->conn);
        } else{
            return mysqli_affected_rows($this->conn);
        }
    }

    private function checkConnectivity(){
        if(!isset($this->conn) || $this->conn=='') {
            return false;
        }
        return true;
    }
} 