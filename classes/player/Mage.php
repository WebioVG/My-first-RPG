<?php

namespace player;

class Mage extends Character
{
    // public $spells = [
    //     ['name' => 'Brasier', 'intensity' => 10, 'description' => 'Un sort enflammant l\'ennemi (faible)'],
    //     ['name' => 'Glacier', 'intensity' => 10, 'description' => 'Un sort gelant l\'ennemi (faible)'],
    //     ['name' => 'Foudre', 'intensity' => 10, 'description' => 'Un sort foudroyant l\'ennemi (faible)'],
    //     ['name' => 'H2O', 'intensity' => 10, 'description' => 'Un sort noyant l\'ennemi (faible)'],
    // ];

    public $spells = [];

    public function __construct($name, $tribe, $inGameID = null, $strength = 10, $power = 30, $health = 100, $mana = 100)
    {
        parent::__construct($name, $tribe);

        $this->setInGameID($inGameID ?? count(Character::all()) + 1);
        $this->setClass('mage');
        $this->setStrength($strength);
        $this->setPower($power);
        $this->setHealth($health);
        $this->setMana($mana);
        $this->setSpells(selectAll('SELECT * FROM spell WHERE id = 1 || id = 2 || id = 3 || id = 4;'));
    }

    // Getters
    public function getSpells()
    {
        return $this->spells; 
    }

    // Setters
    public function setSpells($spells) {
        $this->spells = $spells;

        return $this;
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