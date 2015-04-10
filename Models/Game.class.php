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

    protected function isValidGame($gameId){
        return true;
    }

    public function getMilestones(){
        $dbh = DBHandler::getInstance();
        $dbh->retrieveObjects("Milestone");
        $dbh->disconnect();
    }
} 