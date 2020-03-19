<?php

namespace GeoQuizz\Backoffice\control;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GeoQuizz\Backoffice\model\User as user;
use GeoQuizz\Backoffice\model\Series as series;
use GeoQuizz\Backoffice\model\Picture as picture;
use Firebase\JWT\JWT;

class BackofficeController
{
    protected $c;

    public function __construct(\Slim\Container $c = null)
    {
        $this->c = $c;
    }

    public function userSignin(Request $req, Response $resp, array $args)
    {
        $user_email = $req->getAttribute("user_email");
        $user_password = $req->getAttribute("user_password");
        $user = new user();
        if ($user = user::where('email', '=', $user_email)->first()) {
            if (password_verify($user_password, $user->password)) {
                $token = JWT::encode(
                    ['iss' => 'http://api.backoffice.local',
                        'aud' => 'http://api.backoffice.local',
                        'iat' => time(),
                        'exp' => time() + 3600,
                        'uid' => $user->id,
                        'lvl' => 1],
                    "secret", 'HS512');
                $rs = $resp->withStatus(200)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode([
                    "token" => $token
                ]));
                return $rs;
            } else {
                $rs = $resp->withStatus(401)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode(['type' => 'error', 'Error_code' => 401, 'message :' => 'email ou mot de passe incorrect']));
                return $rs;
            }
        } else {
            echo "aucun compte ne correspond à cette adresse email.";
        }
    }
}
