<?php

class Character
{
    private $name;
    private $class;
    private $tribe;
    private $health = 100;
    private $strength;
    private $mana;

    public function __construct($name, $class, $tribe)
    {
        $this->name = $name;
        $this->class = $class;
        $this->tribe = $tribe;
        switch ($class) {
            case 'warrior':
                $this->strength = 30;
                $this->mana = 10;

                break;
            case 'mage':
                $this->strength = 10;
                $this->mana = 30;

                break;
            case 'hunter':
                $this->strength = 20;
                $this->mana = 20;

                break;
        }
    }

    // Getters
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

    // Setters
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

    // Functions

}