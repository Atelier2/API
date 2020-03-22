<?php
require '../src/vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \lbs\common\bootstrap\Eloquent;
use \DavidePastore\Slim\Validation\Validation as Validation;

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
})->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':headersCORS');

/*Ajoute une photo*/
$app->post('/picture[/]', function ($rq, $rs, $args) {
    return (new GeoQuizz\Mobile\control\MobileController($this))->addPicture($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Mobile\commons\Validators\Validator::validatorsPictures()))
    ->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':headersCORS')
    ->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkHeaderOrigin')
    ->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':decodeJWT')
    ->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkJWT');

/*Récupère toutes les photos*/
$app->get('/picture[/]', function ($rq, $rs, $args) {
    return (new GeoQuizz\Mobile\control\MobileController($this))->getPictures($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Mobile\commons\Validators\Validator::validatorsPictures()))
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':headersCORS')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkHeaderOrigin')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':decodeJWT')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkJWT');

/*Récupère une photo voulu*/
$app->get('/picture/{id}[/]', function ($rq, $rs, $args) {
    return (new GeoQuizz\Mobile\control\MobileController($this))->getPictureId($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Mobile\commons\Validators\Validator::validatorsPictures()))
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':headersCORS')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkHeaderOrigin')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':decodeJWT')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkJWT');


/*Ajoute une série*/
$app->post('/series[/]', function ($rq, $rs, $args) {
    return (new GeoQuizz\Mobile\control\MobileController($this))->createSerie($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Mobile\commons\Validators\Validator::validatorsSeriesPictures()))
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':headersCORS')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkHeaderOrigin')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':decodeJWT')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkJWT');

/*Récupère une série en particulier*/
$app->get('/series/{id}[/]', function ($rq, $rs, $args) {
    return (new GeoQuizz\Mobile\control\MobileController($this))->getSerieId($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Mobile\commons\Validators\Validator::validatorsSeriesPictures()))
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':headersCORS')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkHeaderOrigin')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':decodeJWT')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkJWT');

/*Récupère toutes les séries*/
$app->get('/series[/]', function ($rq, $rs, $args) {
    return (new GeoQuizz\Mobile\control\MobileController($this))->getSeries($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Mobile\commons\Validators\Validator::validatorsSeriesPictures()))
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':headersCORS')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkHeaderOrigin')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':decodeJWT')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkJWT');

/*Create User*/
$app->post('/user/signin', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Mobile\control\MobileController($this))->userSignin($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Mobile\commons\Validators\Validator::validatorsUsers()))
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':headersCORS');

/*User Login*/
$app->post('/user/signup', function ($rq, $rs, $args) {
    return (new \GeoQuizz\Mobile\control\MobileController($this))->userSignup($rq, $rs, $args);
})->add(new \DavidePastore\Slim\Validation\Validation(\GeoQuizz\Mobile\commons\Validators\Validator::validatorsUsers()))
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':headersCORS')
//->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkHeaderOrigin')
->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':decodeAuthorization');
//->add(\GeoQuizz\Mobile\commons\middlewares\Middleware::class . ':checkAuthorization');

$app->run();