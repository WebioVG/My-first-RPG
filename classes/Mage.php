<?php

class Mage extends Character
{
    public function __construct($name, $tribe)
    {
        $this->setName($name);
        $this->setClass('mage');
        $this->setTribe($tribe);
        $this->setStrength(10);
        $this->setMana(30);
    }

    public function castSpell($target)
    {
        $target->setHealth($target->getHealth() - $this->getMana() * 3);
    }
}