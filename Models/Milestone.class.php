<?php

class Milestone {

    private $id;
    private $results;

    public function __construct($id) {
        if($this->isValidMilestone($id)){
            $this->id = $id;
        } else {
            throw new Exception("Is not valid milestone");
        }
    }

    public function getId(){
        return $this->id;
    }

    protected function isValidMilestone($milestoneId){
        return true;
    }

    public function updateStatistics(){
        $this->getResults();
        $this->calculateMode();
        $this->calculateMean();

    }

    private function getResults(){
        $dbh = DBHandler::getInstance();
        $results = $dbh->retrieveObjectsBelongingTo("Result", null, "milestone_id", $this->id));
        //TODO carry on point
    }

    private function store(){

    }
} 