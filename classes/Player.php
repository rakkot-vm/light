<?php
namespace classes;

use traites\UserInteraction;

abstract class Player implements \interfaces\BasePlayer
{
    use UserInteraction;

    const BASE_HEALTH = 100;

    public $name;

    protected $health;
    protected $baseHealth = 100;
    protected $healthRange = [18, 25] ;
    protected $powerAttackRange = [10, 35] ;
    protected $weakAttackRange = [18, 25] ;
    protected $actions = ['weakAttack', 'powerAttack', 'heal'];
    protected $actionsTitles = ['weak attack', 'power attack', 'heal yourself'];
    protected $currentAction;

    public function __construct($name)
    {
        $this->name = $name;
        $this->health = $this->baseHealth;
    }

    public function turnProcess()
    {
        $this->doChoice();

        return $this->doAction();
    }

    public function doAction()
    {
        return call_user_func([$this, $this->currentAction]);
    }

    public function isAlive()
    {
        return boolval($this->health);
    }

    public function getHealth()
    {
        return $this->health;
    }

    protected function weakAttack()
    {
        $this->printMsg($this->name . ' try to attacking ...');

        return $this->attack($this->weakAttackRange);
    }

    protected function powerAttack()
    {
        $this->printMsg($this->name . ' try to power attacking ...');

        return $this->attack($this->powerAttackRange);
    }

    public function attack(array $range)
    {
        return rand($range[0], $range[1]);
    }

    public function damage($damagePoints)
    {
        $damagePoints = $damagePoints > $this->health ? $this->health : $damagePoints;

        $this->health = $this->health - $damagePoints;

        $this->printMsg($this->name . ' taking ' . $damagePoints . ' damage!..');
    }

    public function heal()
    {
        $healPoints = rand($this->healthRange[0], $this->healthRange[1]);

        $this->printMsg($this->name . ' healing himself on '. $healPoints .' health ...');

        $this->health = $this->health + $healPoints;
    }
}