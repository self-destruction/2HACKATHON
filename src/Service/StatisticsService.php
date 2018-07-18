<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class StatisticsService
{
    protected $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function getStats()
    {
        $statArray = $this->conn->fetchAll('SELECT (SELECT COUNT(*) FROM Person) AS personcount, (SELECT COUNT(*) FROM Car) AS carcount, (select count(*) from (SELECT distinct vendor from Car) as vendors) as uniquevendorcount')[0];

        if ($statArray === null) {
            throw new \LogicException('Statistics is null!');
        }

        return $statArray;
    }
}