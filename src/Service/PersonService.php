<?php

namespace App\Service;

use App\Models\Person;
use Doctrine\DBAL\Connection;

class PersonService
{
    protected $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function getPersonCount(Person $person)
    {
        return (int)$this->conn->fetchColumn('SELECT count(id) FROM Person WHERE id = ?', [$person->getIdModel()]);
    }

    public function savePersonModel(Person $person)
    {
        if ($this->getPersonCount($person) > 0){
            throw new \LogicException("id is exists!");
        }

        $sql = 'INSERT INTO Person (id, name, birthdate) VALUES (?, ?, ?)';

        $values = [
            $person->getIdModel(), 
            $person->getNameModel(), 
            $person->getBirthdatelModel()
        ];
        $types = [
            \PDO::PARAM_INT, 
            \PDO::PARAM_STR,
            \PDO::PARAM_STR
        ];
        $stmt = $this->conn->executeQuery($sql, $values, $types);
    }
}