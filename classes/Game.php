<?php
namespace classes;

use traites\UserInteraction;

class Game
{
    use UserInteraction;

    private $isAutoGame = true;
    private $players = [];

    private $currentPlayer;
    private $currentOpponent;
    private $round = 0;

    public $winner;
    public $loser;

    public function __construct()
    {
        $this->configureGame();

        $this->start();
    }

    private function configureGame()
    {
        $this->setGameMode();

        $this->setPlayers();
        $this->shufflePlayers();
    }

    private function setGameMode()
    {
        $this->printMsg('Please choose the game mode : ');
        $this->printArrayAsList(['game with live player', 'auto game (without player, only computers)']);

        $answers = ['1' => 'auto', '0' => 'manual'];

        $this->isAutoGame = $this->getUserInput('', $answers);
    }

    private function setPlayers()
    {
        $firstPlayer = $this->isAutoGame ? new ComputerPlayer('firstPlayer') : new HumanPlayer('firstPlayer');

        array_push($this->players, $firstPlayer);
        array_push($this->players, new ComputerPlayer('secondPlayer'));
    }

    private function shufflePlayers()
    {
        shuffle($this->players);

        $this->currentPlayer = $this->players[0];
        $this->currentOpponent = $this->players[1];
    }

    /**
     * Main game process
     */
    public function start()
    {
        while(!$this->winner){
            $this->round++;

            $this->playerAction();
            $this->status();

            if(!$this->currentOpponent->isAlive()){
                $this->finish();
                break;
            }

            $this->changeCurrentPlayers();
            $this->printMsg('..........');
        }

        $this->gameResult();
    }

    private function playerAction()
    {
        $attackPoints = $this->currentPlayer->turnProcess();

        if(is_numeric($attackPoints)){
            $this->currentOpponent->damage($attackPoints);
        }
    }

    private function changeCurrentPlayers()
    {
        if($this->round % 2 == 0){
            $this->currentPlayer = $this->players[0];
            $this->currentOpponent = $this->players[1];
        }else{
            $this->currentPlayer = $this->players[1];
            $this->currentOpponent = $this->players[0];
        }
    }

    private function status()
    {
        foreach($this->players as $player){
            $this->printMsg($player->name . ' has ' . $player->getHealth() . ' health.');
        }
    }

    private function finish()
    {
        $this->loser = $this->currentOpponent;
        $this->winner = $this->currentPlayer;
    }

    private function gameResult()
    {
        $this->printMsg('Game finished on ' . $this->round . ' turn');
        $this->printMsg('Player '. $this->winner->name . ' win! '. $this->winner->getHealth()  . ' health point left.');
    }

}