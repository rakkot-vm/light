<?php

namespace classes;


class ComputerPlayer extends Player
{
    protected function doChoice()
    {
        $countActions = count($this->actions)-1;

        $action = rand(0, $countActions);

        $this->currentAction = $this->actions[$action];
    }

    public function turnProcess()
    {
        if($this->isLowHealth()){
            $this->increaseHealChance();
        }else{
            $this->normalizeHealChance();
        }

        return parent::turnProcess();
    }

    private function isLowHealth()
    {
        return ($this->baseHealth / 100 * 35) >= $this->health;
    }

    private function increaseHealChance()
    {
        if(!$this->isHealChanceIncreased()) {
            array_push($this->actions, 'heal');
        }
    }

    private function normalizeHealChance()
    {
        if($this->isHealChanceIncreased()) {
            array_splice($this->actions, -1);
        }
    }

    private function isHealChanceIncreased()
    {
        return count($this->actions) > 3;
    }
}