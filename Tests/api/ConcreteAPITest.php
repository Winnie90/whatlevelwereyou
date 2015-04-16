<?php

require_once(__DIR__ . '/../../api/ConcreteAPI.class.php');

class ConcreteAPITest extends PHPUnit_Framework_TestCase {

    public function testNewResult()
    {
        $testArray = [1,2,3,4,1,2,1];
        $mean = stats::calculateMean($testArray);
        $this->assertTrue($mean == 2);
    }

}
 