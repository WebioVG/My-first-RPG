<?php

class Warrior extends Character
{
    public function __construct($name, $tribe, $inGameID = null, $strength = 30, $power = 10, $health = 100, $mana = 100)
    {
        parent::__construct($name, $tribe);

        $this->setInGameID($inGameID ?? count(Character::all()) + 1);
        $this->setClass('warrior');
        $this->setStrength($strength);
        $this->setPower($power);
        $this->setHealth($health);
        $this->setMana($mana);
    }

    public function attack($target)
    {
        $target->setHealth($target->getHealth() - $this->getStrength() * 3);
    }

    public function isAllowedToCastSpells()
    {
        return false;
    }

}