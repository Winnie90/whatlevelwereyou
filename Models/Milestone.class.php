<?php

require_once(__DIR__.'/../helpers/stats.class.php');
require_once(__DIR__.'/../db/DBInterface.class.php');

define("TRIM_PERCENT", 20);

class Milestone {

    private $id;
    private $results;
    private $mode;
    private $mean;
    private $median;
    private $trimmedMean;
    private $range;

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

    private function isValidMilestone($milestoneId){
        return true;
    }

    public function updateStatistics(){
        $this->results = $this->getResultsFromDB();
        $this->runStatistics($this->results);
        if($this->storeStatistics()<1){
            throw new Exception("Could not update exception");
        }
    }

    private function runStatistics($results){
        $this->mode = stats::calculateMode($results);
        $this->mean = stats::calculateMean($results);
        $this->median = stats::calculateMedian($results);
        $this->trimmedMean = stats::calculateTrimmedMean($results);
        $this->range = stats::calculateRange($results);
    }

    private function getResultsFromDB(){
        $dbh = DBHandler::getInstance();
        $this->results = $dbh->retrieveObjectsBelongingTo("Result", null, "milestone_id", $this->id);
        if(!isset($this->results) || count($this->results)< 1){
            throw new Exception("No results available");
        }
        return array_column($this->results, 'value');
    }

    private function storeStatistics(){
        $dbh = DBHandler::getInstance();
        $success = $dbh->updateObject("Milestone", $this->id, $this->toUpdateStatisticsArray());
        return $success;
    }

    public function toUpdateStatisticsArray(){
        $id_array = [];
        if(isset($this->id)){
            $id_array = ["id" => $this->id];
        }
        return array_merge($id_array,
            [
                "trimmed_mean" => $this->trimmedMean,
                "median" => $this->median,
                "mode" => $this->mode,
                "mean" => $this->mean,
                "range" => $this->range
            ]
        );
    }
}
