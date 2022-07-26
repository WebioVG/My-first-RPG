<?php

class Warrior extends Character
{
    public function __construct($name, $tribe)
    {
        $this->setName($name);
        $this->setClass('warrior');
        $this->setTribe($tribe);
        $this->setStrength(30);
        $this->setMana(10);
    }

    public function attack($target)
    {
        $target->setHealth($target->getHealth() - $this->getStrength() * 3);
    }
}