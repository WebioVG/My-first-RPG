<?php

require 'Character.php';

class Dirty
{
    private $name;
    private $class;
    private $tribe;
    private $errors = [];

    public function __construct($name, $class, $tribe) {
        if (strlen($name) <= 15 ) {
            $this->name = $name;
        } else {
            $this->$errors['name'] = 'Le nom est trop long';
        }

        if ($class === 'warrior' || $class === 'mage' || $class === 'hunter') {
            $this->class = $class;
        } else {
            $this->$errors['class'] = 'La classe n\'est pas correcte.';
        }

        if ($tribe === 'human' || $class === 'dwarf' || $class === 'elf') {
            $this->tribe = $tribe;
        } else {
            $this->errors['tribe'] = 'La tribu n\'est pas correcte.';
        }
    }
    
    public function createNewCharacter() {
        if (empty($this->errors)) {
            return new Character($this->name, $this->class, $this->tribe);
        } else {
            return null;
        }
    }
}