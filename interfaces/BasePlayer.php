<?php
namespace interfaces;

interface BasePlayer
{
    function __construct($name);

    function turnProcess();

    function doAction();

    function attack(array $range);

    function isAlive();

    function heal();

    function damage($damagePoints);
}