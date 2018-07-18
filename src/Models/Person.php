<?php

namespace App\Models;

use Doctrine\DBAL\Connection;

class Person
{
    private $id;
    private $name;
    private $birthdate;
    public function __construct($id = null, $name = null, $birthdate = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthdate = $birthdate;
    }

    public function getIdModel() {
        return $this->id;
    }

    public function setIdModel($id) {
        $this->id = $id;
        return $this;
    }

    public function getNameModel() {
        return $this->name;
    }

    public function setNameModel($name) {
        $this->name = $name;
        return $this;
    }

    public function getBirthdatelModel() {
        return $this->birthdate;
    }

    public function setBirthdateModel($birthdate) {
        $this->birthdate = $birthdate;
        return $this;
    }
}