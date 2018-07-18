<?php

namespace App\Models;

use Doctrine\DBAL\Connection;

class Car
{
    private $id;
    private $vendor;
    private $model;
    private $horsepower;
    private $ownerId;
    
    public function __construct($id = null, $vendor = null, $model = null, $horsepower = null, $ownerId = null)
    {
        $this->id = $id;
        $this->vendor = $vendor;
        $this->model = $model;
        $this->horsepower = $horsepower;
        $this->ownerId = $ownerId;
    }

    public function getIdModel() {
        return $this->id;
    }

    public function setIdModel($id) {
        $this->id = $id;
        return $this;
    }

    public function getVendorModel() {
        return $this->vendor;
    }

    public function setVendorModel($vendor) {
        $this->vendor = $vendor;
        return $this;
    }

    public function getModelModel() {
        return $this->model;
    }

    public function setModelModel($model) {
        $this->model = $model;
        return $this;
    }

    public function getHorsepowerModel() {
        return $this->horsepower;
    }

    public function setHorsepowerModel($horsepower) {
        $this->horsepower = $horsepower;
        return $this;
    }

    public function getOwnerIdModel() {
        return $this->ownerId;
    }

    public function setOwnerIdModel($ownerId) {
        $this->ownerId = $ownerId;
        return $this;
    }
}