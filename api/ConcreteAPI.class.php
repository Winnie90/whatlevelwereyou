<?php

require_once 'AbstractAPI.class.php';
require_once '../Models/User.class.php';
require_once '../Models/Game.class.php';
require_once '../Database/DBHandler.class.php';

class ConcreteAPI extends API
{
    protected $User;
    protected $Game;
    protected $db;

    public function __construct($request) {
        //TODO add origin check back in if user token required
        parent::__construct($request);
    }

    protected function milestones($args) {
        switch ($this->method) {
            case 'GET':
                try{
                    $this->getGameFromId($args[0]);
                    return $this->Game->getMilestones();
                }
                catch(Exception $e) {
                    return 'Caught exception: ' . $e->getMessage();
                }
            break;
        default:
            return "Method type not supported";
        }
    }

    protected function getGameFromId($gameId){
        if(!isset($gameId)){
            throw new Exception("No game Id provided");
        }
        $this->Game = new Game($gameId);
    }


}