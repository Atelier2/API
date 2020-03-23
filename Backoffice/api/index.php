<?php
require '../src/vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GeoQuizz\Backoffice\commons\Validators\Validator as validators;
use \lbs\common\bootstrap\Eloquent;


$config = parse_ini_file("../src/conf/conf.ini");
$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

$errors = require '../src/commons/errors/errors.php';
$configuration = new \Slim\Container(['settings' => ['displayErrorDetails' => true]]);
$app_config = array_merge($errors);

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'debug' => true,
        'whoops.editor' => 'sublime',
    ]]);

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS');

$app->post('/user/signup', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->userSignup($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Backoffice\commons\Validators\Validator::validatorsUsers()))->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin');

$app->post('/user/signin', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->userSignin($rq, $rs, $args);
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeAuthorization')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkAuthorization');

$app->get('/series', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->getSeries($rq, $rs, $args);
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->get('/series/{id}', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->getSerie($rq, $rs, $args);
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->post('/series', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->insertSerie($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Backoffice\commons\Validators\Validator::validatorsSeries()))->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->put('/series/{id}', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->updateSerie($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Backoffice\commons\Validators\Validator::validatorsSeries()))->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->put('/picture/{id}', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->updatePicture($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Backoffice\commons\Validators\Validator::validatorsPicture()))->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->post('/picture', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->insertPicture($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Backoffice\commons\Validators\Validator::validatorsPicture()))->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->post('/series/{id}/pictures', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->seriesPictures($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Backoffice\commons\Validators\Validator::validatorSeriesPictures()))->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->run();
