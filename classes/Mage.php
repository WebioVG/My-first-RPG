<?php

class Mage extends Character
{
    public function __construct($name, $tribe)
    {
        $this->setInGameID(count(Character::all()) + 1);
        $this->setName($name);
        $this->setClass('mage');
        $this->setTribe($tribe);
        $this->setStrength(10);
        $this->setPower(30);
    }

    public function castSpell($target)
    {
        $target->setHealth($target->getHealth() - $this->getPower() * 3);
    }
}