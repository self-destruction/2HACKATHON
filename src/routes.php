<?php

use \App\Controller\{
	HelloWorldController,
	PersonController,
	CarController,
	PersonwithcarsController,
	ClearController,
	StatisticsController
};

$app->group('/hello', HelloWorldController::class);
$app->group('/person', PersonController::class);
$app->group('/car', CarController::class);
$app->group('/personwithcars', PersonwithcarsController::class);
$app->group('/clear', ClearController::class);
$app->group('/statistics', StatisticsController::class);