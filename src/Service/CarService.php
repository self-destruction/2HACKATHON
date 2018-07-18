<?php

namespace App\Service;

use App\Models\Car;
use Doctrine\DBAL\Connection;

class CarService
{
    protected $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function getCarCount(Car $car)
    {
        return (int)$this->conn->fetchColumn('SELECT count(id) FROM Car WHERE id = ?', [$car->getIdModel()]);
    }

    public function getPersonBirthdate(Car $car)
    {
        return $this->conn->fetchColumn('SELECT birthdate FROM Person WHERE id = ?', [$car->getOwnerIdModel()]);
    }

    public function saveCarModel(Car $car)
    {
        if ($this->getCarCount($car) > 0){
            throw new \LogicException('id = '. $car->getIdModel() . ' already exists!');
        }

        $personBirthdateDB = $this->getPersonBirthdate($car);


        if (!$personBirthdateDB) {
            throw new \LogicException('person is not exist!');
        }

        $personBirthdate = date_create($personBirthdateDB);
        $nowDate = date_create('now');
        $diffDate = date_diff($personBirthdate, $nowDate)->y;


        if ($diffDate < 18) {
            throw new \LogicException('person age < 18!');
        }


        $sql = 'INSERT INTO Car (id, vendor, model, horsepower, ownerId) VALUES (?, ?, ?, ?, ?)';

        $values = [
            $car->getIdModel(), 
            $car->getVendorModel(), 
            $car->getModelModel(),
            $car->getHorsepowerModel(), 
            $car->getOwnerIdModel(), 
        ];
        $types = [
            \PDO::PARAM_INT, 
            \PDO::PARAM_STR,
            \PDO::PARAM_STR,
            \PDO::PARAM_INT, 
            \PDO::PARAM_INT
        ];
        $this->conn->executeQuery($sql,$values,$types);
    }
}