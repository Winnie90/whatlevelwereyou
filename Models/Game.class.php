<?php

class Game {
    protected $gameId;
    public function __construct($gameId) {
        if($this->isValidGame($gameId)){
            $this->gameId = $gameId;
        } else {
            throw new Exception("Is not valid game");
        }
    }

    public function getId(){
        return $this->gameId;
    }

    protected function isValidGame($gameId){
        return true;
    }

    public function getMilestones(){
        $dbh = DBInterface::getInstance();
        return $dbh->retrieveObjects("Milestone");
    }
} 