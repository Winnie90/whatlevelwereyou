<?php

require_once(__DIR__.'/../../vendor/autoload.php');

class ResultAPITest extends PHPUnit_Framework_TestCase {

    public function testCreatingResult(){
        $client = new GuzzleHttp\Client(['base_url' => 'http://localhost:8888/whatlevelwereyou/api/results']);

        $milestone_id = rand(2, 18);
        $value = rand(0, 100);
        $data = array(
            "milestone_id"=> $milestone_id,
            "value"=>$value
        );

        $req = $client->createRequest('POST', '', ['json' => $data]);
        $response = $client->send($req);
        $this->assertEquals($response->getStatusCode(), 200);
    }
}
