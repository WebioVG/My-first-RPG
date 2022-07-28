<?php

namespace player;

class Mage extends Character
{
    public function __construct($name, $tribe, $inGameID = null, $strength = 10, $power = 30, $health = 100, $mana = 100)
    {
        parent::__construct($name, $tribe);

        $this->setInGameID($inGameID ?? count(Character::all()) + 1);
        $this->setClass('mage');
        $this->setStrength($strength);
        $this->setPower($power);
        $this->setHealth($health);
        $this->setMana($mana);
    }

    public function castSpell($target)
    {
        $target->pullLife($this->getPower() * 3);
    }

    public function isAllowedToCastSpells()
    {
        return true;
    }
}

?>