<?php

require_once(__DIR__ . '/../../helpers/testUtils.class.php');
require_once(__DIR__ . '/../../models/Result.class.php');

class ResultTest extends PHPUnit_Framework_TestCase {

    public function testCreateResultValidMilestone(){
        $result = new Result(2, 2);
        $value = testUtils::getProperty($result, "value");
        $this->assertEquals(2, $value);
    }

    public function testCreateResultNoMilestone(){
        try {
            new Result(null, 2);
        }
        catch (Exception $expected) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testCreateResultInvalidMilestone(){
        //TODO
    }

    public function testStoreResult(){
        $result = new Result(2, 2);
        $result->store();
        $id = testUtils::getProperty($result, "id");
        $this->assertGreaterThan(-1,$id);
    }
}
 