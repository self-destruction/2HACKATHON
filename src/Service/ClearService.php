<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class ClearService
{
    protected $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function clearDB()
    {
        $sql = 'DELETE FROM Person; DELETE FROM Car';
        $this->conn->executeQuery($sql);
    }
}