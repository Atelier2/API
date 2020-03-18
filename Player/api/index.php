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

$app->get('/test[/]', function ($rq, $rs, $args) {
    return (new GeoQuizz\Player\control\PlayerController($this))->test($rq, $rs, $args);
});

$app->run();
