<?php

namespace player;

class Hunter extends Character
{
    public function __construct($name, $tribe, $inGameID = null, $strength = 20, $power = 20, $health = 100, $mana = 50)
    {
        parent::__construct($name, $tribe);

        $this->setInGameID($inGameID ?? count(Character::all()) + 1);
        $this->setClass('hunter');
        $this->setStrength($strength);
        $this->setPower($power);
        $this->setHealth($health);
        $this->setMana($mana);
    }

    public function isAllowedToCastSpells()
    {
        return false;
    }
}

?>