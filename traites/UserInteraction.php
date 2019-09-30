<?php

namespace traites;


trait UserInteraction
{

    protected function printMsg($msg)
    {
        echo $msg . PHP_EOL;
    }

    protected function getUserInput($msg, array $answers = [])
    {
        do {
            $userAnswer = $this->printInput($msg);

            $isAnswerOK = !empty($answers) ? $this->checkUserAnswer($userAnswer, $answers) : true;
        } while (!$isAnswerOK);

        return $userAnswer;
    }

    protected function printInput($msg)
    {
        return readline($msg);
    }

    protected function checkUserAnswer($userAnswer, array $answers)
    {
        return array_key_exists($userAnswer, $answers);
    }

    protected function printArrayAsList($array)
    {
        foreach ($array as $key => $str){
            $this->printMsg($key . ' - for ' . $str);
        }
    }



}