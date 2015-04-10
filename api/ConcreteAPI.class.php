<?php

require_once 'AbstractAPI.class.php';
require_once '../Models/Game.class.php';
require_once '../Database/DBHandler.class.php';

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
                    $game = Game::getGameFromId($args[0]);
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

    protected function results($args) {
        switch ($this->method) {
            case 'POST':
                try{
                    $result = Result::getGameFromId($args[0]);
                    return $result;
                }
                catch(Exception $e) {
                    return 'Caught exception: ' . $e->getMessage();
                }
                break;
            default:
                return "Method type not supported";
        }
    }




}