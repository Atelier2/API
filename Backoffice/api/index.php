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

$app->get('/docs[/]', function (Request $request, Response $response, $args) {
    return $response->write(file_get_contents('docs/index.html'));
});

$app->get('/', function (Request $request, Response $response, $args) {
    $scheme = $request->getUri()->getScheme();
    $host = $request->getUri()->getHost();
    $port = $request->getUri()->getPort();
    $path = $request->getUri()->getPath();
    $docURL = "$scheme://$host:$port$path" . "docs/";

    $response = $response->withHeader("Location", $docURL);
    return $response;
});

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS');

$app->post('/user/signup[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->userSignup($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Backoffice\commons\Validators\Validator::validatorsUsers()))->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin');

$app->post('/user/signin[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->userSignin($rq, $rs, $args);
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeAuthorization')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkAuthorization');

$app->get('/series[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->getSeries($rq, $rs, $args);
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->get('/series/{id}[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->getSerie($rq, $rs, $args);
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->post('/series[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->insertSerie($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Backoffice\commons\Validators\Validator::validatorsSeries()))->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->put('/series/{id}[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->updateSerie($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Backoffice\commons\Validators\Validator::validatorsSeries()))->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->get('/pictures[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->getPictures($rq, $rs, $args);
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->get('/pictures/{id}[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->getPicture($rq, $rs, $args);
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->put('/pictures/{id}[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->updatePicture($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Backoffice\commons\Validators\Validator::validatorsPicture()))->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->post('/pictures[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->insertPicture($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Backoffice\commons\Validators\Validator::validatorsPicture()))->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->post('/series/{id}/pictures[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->seriesPictures($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Backoffice\commons\Validators\Validator::validatorSeriesPictures()))->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->post('/serie/{id}/picture[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->seriePicture($rq, $rs, $args);
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->post('/user/check-token[/]', function ($rq, $rs, $args) {
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':validJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->get('/serie/{id}/pictures[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->notAssociatedPictures($rq, $rs, $args);
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->get('/serie/{id}/pics[/]', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Backoffice\control\BackofficeController($this))->AssociatedPictures($rq, $rs, $args);
})->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':headersCORS')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkHeaderOrigin')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':decodeJWT')->add(\GeoQuizz\Backoffice\commons\middlewares\Middleware::class . ':checkJWT');

$app->run();
