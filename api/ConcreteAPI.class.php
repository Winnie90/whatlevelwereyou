<?php

require_once 'AbstractAPI.class.php';
require_once(__DIR__ . '/../models/Game.class.php');
require_once(__DIR__ . '/../models/Result.class.php');
require_once(__DIR__ . '/../db/DBInterface.class.php');

class ConcreteAPI extends API
{
    protected $Game;

    public function __construct($request) {
        //TODO add origin check back in if user token required
        parent::__construct($request);
    }

    protected function milestones($args) {
        switch ($this->method) {
            case 'GET':
                try{
                    $game = new Game($args[0]);
                    return $game->getMilestones($game->getId());
                }
                catch(Exception $e) {
                    return 'Caught exception: ' . $e->getMessage();
                }
            break;
        default:
            return "Method type not supported";
        }
    }

    protected function results() {
        switch ($this->method) {
            case 'POST':
                try{
                    $this->checkInputJSON();
                    $milestone = $this->checkValidIntParameter("milestone_id");
                    $value = $this->checkValidIntParameter("value");
                    $userId = $this->checkValidIntParameter("userId");
                    $playtime = $this->checkValidIntParameter("playtime");
                    $result = new Result($milestone, $value, $userId, $playtime);
                    if($result->store() > -1){
                        return $result->toArray();
                    } else {
                        throw new ErrorException("Could not store result");
                    }
                }
                catch(Exception $e) {
                    return 'Caught exception: ' . $e->getMessage();
                }
                break;
            default:
                return "Method type not supported";
        }
    }

    private function checkInputJSON(){
        if(!isset($this->json)){
            throw new InvalidArgumentException("Invalid json provided");
        }

    }

    private function checkValidIntParameter($parameter){
        isset($this->json[$parameter]) ? $return_value = (int)$this->json[$parameter] : $return_value = null;
        return $return_value;
    }
}