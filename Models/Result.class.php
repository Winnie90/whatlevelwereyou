<?php

require_once("Milestone.class.php");

class Result {
    private $milestone;
    private $value;
    private $userId;
    private $playtime;
    private $id;

    public function __construct($milestoneId, $value, $userId=null, $playtime=null) {
        if(!isset($milestoneId)){
            throw new Exception("No milestone provided");
        }
        if(!isset($value)){
            throw new Exception("No value provided");
        }
        $this->milestone = new Milestone($milestoneId);
        $this->value = $value;
        $this->userId = isset($userId) ? $userId : -1;
        $this->playtime = isset($playtime) ? $userId : -1;
    }

    public function store(){
        $dbh = DBHandler::getInstance();
        $this->id = $dbh->insertObject("Result", $this->toArray());
        $this->milestone->updateStatistics();
        return $this->id;
    }

    public function toArray(){
        $id_array = [];
        if(isset($this->id)){
          $id_array = ["id" => $this->id];
        }
        return array_merge($id_array, ["milestone_id" => $this->milestone->getId(),
            "value" => $this->value,
            "user_id" => $this->userId,
            "playtime" => $this->playtime]);
    }
}
