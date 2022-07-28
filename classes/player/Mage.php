<?php

namespace player;

class Mage extends Character
{
    // Properties
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
    public function getSpell(string $spellName)
    {
        return array_values(array_filter($this->getSpells(), function($spell) use($spellName) {
            return $spell['name'] === $spellName;
        }))[0];

        return null;
    }

    // Setters
    public function setSpells(array $spells)
    {
        $this->spells = $spells;

        return $this;
    }

    /////////////
    // METHODS //
    /////////////

    /**
     * Casts a given spell to a given target.
     */
    public function castSpell(Character $target, string $spellName)
    {
        if (!$this->hasSpell($spellName)) { return; }

        $target->pullLife($this->calculateSpellDamage($spellName));
        $this->setMana($this->getMana() - $this->getSpell($spellName)['cost']);

        $this->updateStats();

        return $this;
    }

    /**
     * Calculates the spell damage. Depends on spell intensity and character power.
     */
    public function calculateSpellDamage(string $spellName)
    {
        return ($this->getSpell($spellName)['intensity'] + $this->getPower()) * 0.8;
    }

    /**
     * Checks whether the instance has a spell of a given name.
     */
    public function hasSpell(string $spell)
    {
        $hasSpell = false;

        foreach ($this->getSpells() as $knownSpell) {
            if ($knownSpell['name'] === $spell) {
                $hasSpell = true;
            }
        }

        return $hasSpell;
    }

    public function isAllowedToCastSpells()
    {
        return true;
    }
}

?>