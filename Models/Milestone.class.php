<?php

require_once(__DIR__.'/../helpers/stats.class.php');
require_once(__DIR__ . '/../db/DBInterface.class.php');

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
        $this->getMilestone($id);
    }

    public function getId(){
        return $this->id;
    }

    private function getMilestone($milestoneId){
        $milestoneArray = $this->retrieveMilestoneFromDB($milestoneId);
        $this->initFromArray($milestoneArray);
    }

    private function retrieveMilestoneFromDB($milestoneId){
        $dbh = DBInterface::getInstance();
        $milestoneArray = $dbh->retrieveObjects("Milestone", null, ["id" . " = " . $milestoneId]);
        if(!isset($milestoneArray)){
            throw new Exception("Milestone does not exist available");
        }
        return $milestoneArray;
    }

    private function initFromArray($properties){
        foreach($properties as $key => $value){
            $this->{$key} = $value;
        }
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
        $dbh = DBInterface::getInstance();
        $this->results = $dbh->retrieveObjectsBelongingTo("Result", null, "milestone_id", $this->id);
        if(!isset($this->results) || count($this->results)< 1){
            throw new Exception("No results available");
        }
        return array_column($this->results, 'value');
    }

    private function storeStatistics(){
        $dbh = DBInterface::getInstance();
        $success = $dbh->updateObject("Milestone", $this->id, $this->toUpdateStatisticsArray());
        return $success;
    }

    public function toUpdateStatisticsArray(){
        return [
                "trimmed_mean" => $this->trimmedMean,
                "median" => isset($this->median) ? $this->median : 0,
                "mode" => $this->mode,
                "mean" => $this->mean,
                "range" => $this->range
        ];

    }
}
