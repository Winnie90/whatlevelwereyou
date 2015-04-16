<?php

require_once(__DIR__ . '/../../helpers/testUtils.class.php');
require_once(__DIR__ . '/../../models/Milestone.class.php');

class MilestoneTest extends PHPUnit_Framework_TestCase {

    private $milestone;

    public function setUp(){

    }
    public function tearDown(){ }

    public function testCreateValidMilestone()
    {
        $this->milestone = new Milestone(1);
    }

    public function testRunStatistics()
    {
        $testArray = [1,2,3,4,1,2,1];
        $this->milestone = new Milestone(1);
        $runStatisticsMethod = testUtils::getMethod("Milestone","runStatistics");
        $runStatisticsMethod->invoke($this->milestone, $testArray);

        $trimmedMean = testUtils::getProperty($this->milestone, "trimmedMean");
        $this->assertEquals($trimmedMean, 1.8);
    }

    public function testInitFromArray()
    {
        $testArray = ["trimmedMean" => 1.8];
        $this->milestone = new Milestone(1);
        $initFromArray = testUtils::getMethod("Milestone","initFromArray");
        $initFromArray->invoke($this->milestone, $testArray);

        $trimmedMean = testUtils::getProperty($this->milestone, "trimmedMean");
        $this->assertEquals($trimmedMean, 1.8);
    }
}
 