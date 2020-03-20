<?php

namespace GeoQuizz\Backoffice\control;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GeoQuizz\Backoffice\model\User as user;
use GeoQuizz\Backoffice\model\Series as series;
use GeoQuizz\Backoffice\model\Picture as picture;
use Firebase\JWT\JWT;
use Ramsey\Uuid\Uuid;

class BackofficeController
{
    protected $c;

    public function __construct(\Slim\Container $c = null)
    {
        $this->c = $c;
    }

    public function userSignup(Request $req, Response $resp, array $args)
    {
        $user_email = $req->getAttribute("user_email");
        $user_password = $req->getAttribute("user_password");
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
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode(['type' => 'error', 'Error_code' => 401, 'message :' => 'aucun compte ne correspond à cette adresse email']));
            return $rs;
        }
    }


    public function userSignin(Request $req, Response $resp, array $args)
    {
        if (!$req->getAttribute('errors')) {
            $user = new user();
            $getParsedBody = $req->getParsedBody();
            $user->id = Uuid::uuid4();
            $user->token = "test";
            $user->firstname = filter_var($getParsedBody["firstname"], FILTER_SANITIZE_STRING);
            $user->lastname = filter_var($getParsedBody["lastname"], FILTER_SANITIZE_STRING);
            $user->email = filter_var($getParsedBody["email"], FILTER_SANITIZE_EMAIL);
            $user->password = password_hash($getParsedBody["password"], PASSWORD_DEFAULT);
            $user->phone = filter_var($getParsedBody["phone"], FILTER_SANITIZE_NUMBER_INT);
            $user->street_number = filter_var($getParsedBody["street_number"], FILTER_SANITIZE_NUMBER_INT);
            $user->street = filter_var($getParsedBody["street"], FILTER_SANITIZE_STRING);
            $user->city = filter_var($getParsedBody["city"], FILTER_SANITIZE_STRING);
            $user->zip_code = filter_var($getParsedBody["zip_code"], FILTER_SANITIZE_STRING);
            $user->created_at = date("Y-m-d H:i:s");
            $user->updated_at = date("Y-m-d H:i:s");
            $user->save();
            $rs = $resp->withStatus(201)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("votre compte utilisateur a bien été crée"));
            return $rs;
        } else {
            $errors = $req->getAttribute('errors');
            $errorsArray = array();
            foreach ($errors as $error) {
                $errorsArray["error"][] = $error[0];
            }
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errorsArray["error"]));
            return $rs;
        }
    }

}
