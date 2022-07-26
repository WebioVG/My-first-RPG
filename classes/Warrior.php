<?php

class Warrior extends Character
{
    public function __construct($name, $tribe, $inGameID = null, $strength = 30, $power = 10, $health = 100, $mana = 100)
    {
        $this->setInGameID($inGameID ?? count(Character::all()) + 1);
        $this->setName($name);
        $this->setClass('warrior');
        $this->setTribe($tribe);
        $this->setStrength($strength);
        $this->setPower($power);
        $this->setHealth($health);
        $this->setMana($mana);
    }

    public function attack($target)
    {
        $target->setHealth($target->getHealth() - $this->getStrength() * 3);
    }
}