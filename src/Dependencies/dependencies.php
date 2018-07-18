<?php

use \Psr\Container\ContainerInterface;
use \App\Controller\{
	HelloWorldController,
	PersonController,
	CarController,
	PersonwithcarsController,
	ClearController,
    StatisticsController
};
use App\Service\ConnectionFactory;

$container = $app->getContainer();

$container['db.config'] = function (ContainerInterface $c) {
    return ConnectionFactory::getConnection();
};

// HelloWorldController
$container[HelloWorldController::class] = function (ContainerInterface $c) use ($app) {
    return new HelloWorldController($app);
};

// PersonController
$container[PersonController::class] = function (ContainerInterface $c) use ($app) {
    return new PersonController($app, $c->get('db.config'));
};

// CarController
$container[CarController::class] = function (ContainerInterface $c) use ($app) {
    return new CarController($app, $c->get('db.config'));
};

// PersonwithcarsController
$container[PersonwithcarsController::class] = function (ContainerInterface $c) use ($app) {
    return new PersonwithcarsController($app, $c->get('db.config'));
};

// ClearController
$container[ClearController::class] = function (ContainerInterface $c) use ($app) {
    return new ClearController($app, $c->get('db.config'));
};

// StatisticsController
$container[StatisticsController::class] = function (ContainerInterface $c) use ($app) {
    return new StatisticsController($app, $c->get('db.config'));
};