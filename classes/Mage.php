<?php

class Mage extends Character
{
    public function __construct($name, $tribe, $inGameID = null, $strength = 10, $power = 30, $health = 100, $mana = 100)
    {
        $this->setInGameID($inGameID ?? count(Character::all()) + 1);
        $this->setName($name);
        $this->setClass('mage');
        $this->setTribe($tribe);
        $this->setStrength($strength);
        $this->setPower($power);
        $this->setHealth($health);
        $this->setMana($mana);

    }

    public function castSpell($target)
    {
        $target->setHealth($target->getHealth() - $this->getPower() * 3);
    }
}