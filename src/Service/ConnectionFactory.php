<?php

namespace App\Service;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class ConnectionFactory
{
    /**
     * @return Doctrine\DBAL\Connection
     */
    public static function getConnection()
    {
     //    $config = new Configuration();
     //    return DriverManager::getConnection(
     //    	include('config/doctrine.php'), 
     //    	$config
    	// );

  //   	$configParams = [
		// 	'driver' => 'pdo_mysql',
		// 	'host' => '127.0.0.1',
		// 	'dbname' => 'team',
		// 	'user' => 'root',
		// 	'password' => 'root',
		// 	'charset' => 'utf8'
		// ]; 
        $configParams = [
            'driver' => 'pdo_mysql',
            'host' => '195.26.178.88',
            'dbname' => 'team',
            'user' => 'root',
            'password' => '0eIR2jjj',
            'port' => 30501,
            'charset' => 'utf8'
        ];
	    $config = new Configuration();
        return DriverManager::getConnection(
        	$configParams, 
        	$config
    	);
    }
}