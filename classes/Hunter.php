<?php

class Hunter extends Character
{
    public function __construct($name, $tribe)
    {
        $this->setName($name);
        $this->setClass('hunter');
        $this->setTribe($tribe);
        $this->setStrength(20);
        $this->setMana(20);
    }

    public function rangedAttack($target)
    {
        $target->setHealth($target->getHealth() - $this->getStrength() * 2);
    }
}