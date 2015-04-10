<?php

class Milestone {
    protected $milestoneId;

    public function __construct($milestoneId) {
        if($this->isValidMilestone($milestoneId)){
            $this->milestoneId = $milestoneId;
        } else {
            throw new Exception("Is not valid milestone");
        }
    }
} 