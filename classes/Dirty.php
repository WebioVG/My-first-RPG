<?php

require 'Character.php';

class Dirty
{
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
    
    public function createNewCharacter()
    {
        if (empty($this->errors)) {
            switch ($this->class) {
                case 'warrior':
                        return new Warrior($this->name, $this->tribe);
                        
                    break;
                    case 'mage':
                        return new Mage($this->name, $this->tribe);
                        
                        break;
                    case 'hunter':
                        return new Hunter($this->name, $this->tribe);
        
                        break;
                }
        } else {
            return null;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}