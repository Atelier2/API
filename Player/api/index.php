<?php
require '../src/vendor/autoload.php';

use GeoQuizz\Player\commons\database\DatabaseConnection;

$settings = require_once "../src/conf/settings.php";
$errorsHandlers = require_once "../src/commons/errors/errorHandlers.php";
$app_config = array_merge($settings, $errorsHandlers);

$container = new \Slim\Container($app_config);
$app = new \Slim\App($container);

DatabaseConnection::startEloquent(($app->getContainer())->settings['dbconf']);

$app->get('/series[/]', \GeoQuizz\Player\control\PlayerController::class.':getSeries');
$app->get('/series/{id}[/]', \GeoQuizz\Player\control\PlayerController::class.':getSeriesWithId');
$app->post('/game[/]', \GeoQuizz\Player\control\PlayerController::class.':createGame');

$app->run();
