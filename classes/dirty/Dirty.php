<?php

namespace dirty;

use player\Hunter;
use player\Mage;
use player\Warrior;

class Dirty
{
    // Properties
    private $name;
    private $class;
    private $tribe;
    private $errors = [];

    public function __construct($name, $class, $tribe)
    {
        if (strlen($name) === 0 ) {
            $this->errors['name'] = 'Le nom n\'a pas été renseigné.';
        } elseif (strlen($name) > 15) {
            $this->errors['name'] = 'Le nom est trop long.';
        } else {
            $this->name = $name;
        }

        if ($class === 'warrior' || $class === 'mage' || $class === 'hunter') {
            $this->class = $class;
        } else {
            $this->errors['class'] = 'La classe n\'est pas correcte.';
        }

        if ($tribe === 'human' || $tribe === 'dwarf' || $tribe === 'elf') {
            $this->tribe = $tribe;
        } else {
            $this->errors['tribe'] = 'La tribu n\'est pas correcte.';
        }
    }
    
    /**
     * Creates a new instance of Warrior, Mage or Hunter if there is no error.
     */
    public function createNewCharacter()
    {
        if (!empty($this->errors)) { return null; }

        switch ($this->class) {
            case 'warrior':
                return new Warrior($this->name, $this->tribe); break;
            case 'mage':
                return new Mage($this->name, $this->tribe); break;
            case 'hunter':
                return new Hunter($this->name, $this->tribe); break;
        }
    }

    /**
     * Get all errors regarding the name, class and tribe properties.
     */
    public function getErrors()
    {
        return $this->errors;
    }
}