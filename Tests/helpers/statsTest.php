<?php

require_once(__DIR__ . '/../../helpers/stats.class.php');

class statsTest extends PHPUnit_Framework_TestCase {

    public function testModeBasicArray()
    {
        $testArray = [1,2,3,4,1,2,1];
        $mode = stats::calculateMode($testArray);
        $this->assertTrue($mode == 1);
    }

    public function testDualModeArray()
    {
        $testArray = [1,2,3,4,1,2,2,1];
        $mode = stats::calculateMode($testArray);
        $this->assertEquals(1, $mode);
    }

    public function testModeNoArray()
    {
        try {
            $testArray = "hello";
            stats::calculateMode($testArray);
        }
        catch (Exception $expected) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testMeanBasicArray()
    {
        $testArray = [1,2,3,4,1,2,1];
        $mean = stats::calculateMean($testArray);
        $this->assertTrue($mean == 2);
    }

    public function testMeanNoArray()
    {
        try {
            $testArray = "hello";
            stats::calculateMean($testArray);
        }
        catch (Exception $expected) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testMedianBasicArray()
    {
        $testArray = [1,2,3,4,1,2,1];
        $median = stats::calculateMedian($testArray);
        $this->assertEquals($median, 2);
    }

    public function testDualMedianArray()
    {
        $testArray = [1,2,3,4,1,3,4,1];
        $median = stats::calculateMedian($testArray);
        $this->assertEquals($median, 3);
    }

    public function testMedianNoArray()
    {
        try {
            $testArray = "hello";
            stats::calculateMedian($testArray);
        }
        catch (Exception $expected) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testTrimmedMeanBasicArray()
    {
        $testArray = [8, 3, 7, 1, 3, 9];
        $trimmedMean = stats::calculateTrimmedMean($testArray);
        $this->assertTrue($trimmedMean == 5.25);
    }

    public function testTrimmedMeanOneArray()
    {
        $testArray = [8];
        $trimmedMean = stats::calculateTrimmedMean($testArray);
        $this->assertTrue($trimmedMean == 8);
    }

    public function testTrimmedMeanNoArray()
    {
        try {
            $testArray = "hello";
            stats::calculateTrimmedMean($testArray);
        }
        catch (Exception $expected) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testRangeArrayInt(){
        $testArray = [8, 3, 7, 1, 3, 9, 10];
        $range = stats::calculateRange($testArray);
        $this->assertTrue($range == 9);
    }

    public function testRangeArrayFloat(){
        $testArray = [8, 3, 7, 1, 3, 9, 10, 10.5];
        $range = stats::calculateRange($testArray);
        $this->assertTrue($range == 9.5);
    }

    public function testRangeNoArray()
    {
        try {
            $testArray = "[8, 3]";
            stats::calculateRange($testArray);
        }
        catch (Exception $expected) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }
}
 