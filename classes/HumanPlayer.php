<?php
namespace classes;


class HumanPlayer extends Player
{
    protected function doChoice()
    {
        $this->printMsg('Select an action: ');
        $this->printArrayAsList($this->actionsTitles);


        $action = $this->getUserInput('', $this->actions);

        $this->currentAction = $this->actions[$action];
    }
}