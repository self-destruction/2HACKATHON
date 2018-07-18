<?php

namespace App\Service;

use App\Models\{Person, Car};
use Doctrine\DBAL\Connection;

class PersonwithcarsService
{
    protected $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function loadPersonModel($personid)
    {
        $person = $this->conn->fetchAll('SELECT * FROM Person WHERE id = ?', [$personid])[0];

        if ($person === null) {
        	throw new \LogicException('person with id ' . $personid . ' not found!', 404);
        }

        return new Person(
            $person['id'],
            $person['name'],
            $person['birthdate']
        );
    }

    public function loadCarsArray(Person $person)
    {
        $cars = $this->conn->fetchAll('SELECT * FROM Car WHERE ownerId = ?', [$person->getIdModel()]);

        $carsAssocArray = [];

        foreach ($cars as $car) {
        	$carsAssocArray[] = [
        		'id' => $car['id'],
        		'model' => $car['vendor'] . '-' . $car['model'],
        		'horsepower' => $car['horsepower'],
        		'ownerId' => $car['ownerId']
        	];
        }

        return $carsAssocArray;
    }
}