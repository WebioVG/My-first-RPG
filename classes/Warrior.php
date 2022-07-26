<?php

class Warrior extends Character
{
    public function __construct($name, $tribe)
    {
        $this->setInGameID(count(Character::all()) + 1);
        $this->setName($name);
        $this->setClass('warrior');
        $this->setTribe($tribe);
        $this->setStrength(30);
        $this->setPower(10);
    }

    public function attack($target)
    {
        $target->setHealth($target->getHealth() - $this->getStrength() * 3);
    }
}