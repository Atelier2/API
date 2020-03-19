<?php
require '../src/vendor/autoload.php';

use GeoQuizz\Player\commons\database\DatabaseConnection;
use GeoQuizz\Player\commons\middlewares\CORS;
use GeoQuizz\Player\control\PlayerController;

$settings = require_once "../src/conf/settings.php";
$errorsHandlers = require_once "../src/commons/errors/errorHandlers.php";
$app_config = array_merge($settings, $errorsHandlers);

$container = new \Slim\Container($app_config);
$app = new \Slim\App($container);

DatabaseConnection::startEloquent(($app->getContainer())->settings['dbconf']);

$app->get('/series[/]', PlayerController::class.':getSeries')
    ->add(CORS::class.':addCORSHeaders');

$app->get('/series/{id}[/]', PlayerController::class.':getSeriesWithId')
    ->add(CORS::class.':addCORSHeaders');

$app->post('/game[/]', PlayerController::class.':createGame')
    ->add(CORS::class.':addCORSHeaders');

$app->run();
