<?php

namespace player;

abstract class Character
{
    // Properties
    private $inGameID;
    private $name;
    protected $class;
    protected $tribe;
    protected $health;
    protected $strength;
    protected $mana;
    protected $power;
    private $isDead = false;

    // Constructor
    public function __construct($name, $tribe)
    {
        $this->name = $name;
        $this->tribe = $tribe;
    }

    // Getters
    public function getAllProperties()
    {
        return [
            'inGameID' => $this->inGameID,
            'name' => $this->name,
            'class' => $this->class,
            'tribe' => $this->tribe,
            'health' => $this->health,
            'strength' => $this->strength,
            'mana' => $this->mana,
            'power' => $this->power,
            'isDead' => $this->isDead
        ];
    }
    public function getinGameID()
    {
        return $this->inGameID;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getClass()
    {
        return $this->class;
    }
    public function getTribe()
    {
        return $this->tribe;
    }
    public function getHealth()
    {
        return $this->health;
    }
    public function getStrength()
    {
        return $this->strength;
    }
    public function getMana()
    {
        return $this->mana;
    }
    public function getPower()
    {
        return $this->power;
    }
    public function getIsDead()
    {
        return $this->isDead;
    }

    // Setters
    public function setInGameID($inGameID)
    {
        $this->inGameID = $inGameID;

        return $this;
    }
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }
    public function setTribe($tribe)
    {
        $this->tribe = $tribe;

        return $this;
    }
    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }
    public function setStrength($strength)
    {
        $this->strength = $strength;

        return $this;
    }
    public function setMana($mana)
    {
        $this->mana = $mana;

        return $this;
    }
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }
    public function setIsDead($isDead)
    {
        $this->isDead = $isDead;

        return $this;
    }

    // Methods
    public function save()
    {
        insert('INSERT INTO player (inGameID, name, class, tribe, health, strength, mana, power) VALUES (:inGameID, :name, :class, :tribe, :health, :strength, :mana, :power);', [
            'inGameID' => $this->inGameID,
            'name' => $this->name,
            'class' => $this->class,
            'tribe' => $this->tribe,
            'health' => $this->health,
            'strength' => $this->strength,
            'mana' => $this->mana,
            'power' => $this->power
        ]);

        return $this;
    }

    public function updateStats()
    {
        update('UPDATE player SET health=:health, strength=:strength, mana=:mana, power=:power WHERE inGameID='.$this->getinGameID(), [
            'health' => $this->getHealth(),
            'strength' => $this->getStrength(),
            'mana' => $this->getMana(),
            'power' => $this->getPower(),
        ]);
    }

    public static function load($id)
    {
        $player = selectOne('SELECT inGameID, name, class, tribe, health, strength, mana, power FROM player WHERE inGameID = '.$id.';');
        if ($player['class'] === 'warrior') {
            return new Warrior ($player['name'], $player['tribe'], $player['inGameID'], $player['strength'], $player['power'], $player['health'], $player['mana']);
        } elseif ($player['class'] === 'mage') {
            return new Mage ($player['name'], $player['tribe'], $player['inGameID'], $player['strength'], $player['power'], $player['health'], $player['mana']);
        } elseif ($player['class'] === 'hunter') {
            return new Hunter ($player['name'], $player['tribe'], $player['inGameID'], $player['strength'], $player['power'], $player['health'], $player['mana']);
        }

        return $player;
    }

    public function genericAttack($opponent)
    {
        if ($this instanceof Warrior) {
            $this->attack($opponent);
        }
        if ($this instanceof Mage) {
            $this->castSpell($opponent);
        }
        if ($this instanceof Hunter) {
            $this->rangedAttack($opponent);
        }

        return $this;
    }

    public function pullLife($amount)
    {
        if ($this->getHealth() - $amount < 0) {
            $this->setHealth(0);
            $this->setIsDead(true);
        } else {
            $this->setHealth($this->getHealth() - $amount);
        }

        $this->updateStats();

        return $this;
    }

    public static function all()
    {
        return selectAll('SELECT * FROM player');
    }

    abstract public function isAllowedToCastSpells();
}

?>