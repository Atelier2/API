<?php

namespace lbs\command\control;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use lbs\command\model\Item as item;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use lbs\command\model\Commande as commande;
use Ramsey\Uuid\Uuid;
use GuzzleHttp\Client;

class MobileController
{
    protected $c;

    public function __construct(\Slim\Container $c = null)
    {
        $this->c = $c;
    }

    public function test(Request $req, Response $resp, array $args)
    {
        $rs = $resp->withStatus(200)
            ->withHeader('Content-Type', 'application/json;charset=utf-8');
        $rs->getBody()->write(json_encode("test"));
        return $rs;
    }
}
