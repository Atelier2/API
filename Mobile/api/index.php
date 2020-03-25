<?php
require '../src/vendor/autoload.php';

use GeoQuizz\Mobile\commons\database\DatabaseConnection;
use GeoQuizz\Mobile\commons\middlewares\BasicAuth;
use GeoQuizz\Mobile\commons\middlewares\Checker;
use GeoQuizz\Mobile\commons\middlewares\CORS;
use GeoQuizz\Mobile\commons\middlewares\JWT;
use GeoQuizz\Mobile\commons\middlewares\Validator;
use GeoQuizz\Mobile\control\DocsController;
use GeoQuizz\Mobile\control\PictureController;
use GeoQuizz\Mobile\control\UserController;
use GeoQuizz\Mobile\control\SeriesController;

$settings = require_once "../src/conf/settings.php";
$errorsHandlers = require_once "../src/commons/errors/errorHandlers.php";
$app_config = array_merge($settings, $errorsHandlers);

$container = new \Slim\Container($app_config);
$app = new \Slim\App($container);

DatabaseConnection::startEloquent(($app->getContainer())->settings['dbconf']);

$app->post('/users/signin[/]', UserController::class.':signIn')
    ->add(BasicAuth::class.':decodeBasicAuth')
    ->add(CORS::class.':addCORSHeaders');

$app->post('/users/signup[/]', UserController::class.':signUp')
    ->add(Validator::class.':dataFormatErrorHandler')
    ->add(Validator::createUserValidator())
    ->add(CORS::class.':addCORSHeaders');

$app->get('/users/{id}/series[/]', SeriesController::class.':getSeries')
    ->add(JWT::class.':checkJWT')
    ->add(Checker::class.':userExists')
    ->add(CORS::class.':addCORSHeaders');

$app->post('/users/{id}/series[/]', SeriesController::class.':createSeries')
    ->add(JWT::class.':checkJWT')
    ->add(Checker::class.':userExists')
    ->add(Validator::class.':dataFormatErrorHandler')
    ->add(Validator::createSeriesValidator())
    ->add(CORS::class.':addCORSHeaders');

$app->post('/users/{id}/pictures[/]', PictureController::class.':addPicture')
    ->add(JWT::class.':checkJWT')
    ->add(Checker::class.':userExists')
    ->add(Validator::class.':dataFormatErrorHandler')
    ->add(Validator::addPictureValidator())
    ->add(CORS::class.':addCORSHeaders');

$app->post('/users/{id_user}/series/{id_series}/pictures[/]', PictureController::class.':addPictureToSeries')
    ->add(JWT::class.':checkJWT')
    ->add(Checker::class.':seriesExists')
    ->add(Checker::class.':userExists')
    ->add(CORS::class.':addCORSHeaders');

$app->options('/{routes:.+}', function ($request, $response, $args) { return $response; })
    ->add(CORS::class.':addCORSHeaders');

$app->get('/docs[/]', DocsController::class.':renderDocsHtmlFile')
    ->add(CORS::class.':addCORSHeaders');

$app->get('/', DocsController::class.':redirectTowardsDocs')
    ->add(CORS::class.':addCORSHeaders');

$app->run();
