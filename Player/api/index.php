<?php
require '../src/vendor/autoload.php';

use GeoQuizz\Player\commons\database\DatabaseConnection;
use GeoQuizz\Player\commons\middlewares\CORS;
use GeoQuizz\Player\commons\middlewares\JWT;
use GeoQuizz\Player\control\SeriesController;
use GeoQuizz\Player\control\GameController;
use GeoQuizz\Player\control\PictureController;

$settings = require_once "../src/conf/settings.php";
$errorsHandlers = require_once "../src/commons/errors/errorHandlers.php";
$app_config = array_merge($settings, $errorsHandlers);

$container = new \Slim\Container($app_config);
$app = new \Slim\App($container);

DatabaseConnection::startEloquent(($app->getContainer())->settings['dbconf']);

$app->get('/series[/]', SeriesController::class.':getSeries')
    ->add(CORS::class.':addCORSHeaders');

$app->get('/series/{id}[/]', SeriesController::class.':getSeriesWithId')
    ->add(CORS::class.':addCORSHeaders');

$app->get('/series/{id}/pictures[/]', PictureController::class.':getPicturesOfOneSeries')
    ->add(CORS::class.':addCORSHeaders');

$app->get('/games/{id}[/]', GameController::class.':getGameWithId')
    ->add(JWT::class.':checkJWT')
    ->add(CORS::class.':addCORSHeaders');

$app->post('/games[/]', GameController::class.':createGame')
    ->add(CORS::class.':addCORSHeaders');

$app->options('/{routes:.+}', function ($request, $response, $args) { return $response; })
    ->add(CORS::class.':addCORSHeaders');

$app->run();
