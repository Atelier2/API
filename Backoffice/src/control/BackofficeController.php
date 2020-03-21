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
        if ($user = user::where('email', '=', $user_email)->firstOrFail()) {
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
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }


    public function insertSerie(Request $req, Response $resp, array $args)
    {
        if (!$req->getAttribute('errors')) {
            $token = $req->getAttribute("token");
            $series = new series();
            $getParsedBody = $req->getParsedBody();
            $series->id = Uuid::uuid4();
            $series->city = filter_var($getParsedBody["city"], FILTER_SANITIZE_STRING);
            $series->distance = filter_var($getParsedBody["distance"], FILTER_SANITIZE_NUMBER_INT);
            $series->latitude = filter_var($getParsedBody["latitude"], FILTER_SANITIZE_STRING);
            $series->longitude = filter_var($getParsedBody["longitude"], FILTER_SANITIZE_STRING);
            $series->zoom = filter_var($getParsedBody["zoom"], FILTER_SANITIZE_NUMBER_INT);
            $series->nb_pictures = filter_var($getParsedBody["nb_pictures"], FILTER_SANITIZE_NUMBER_INT);
            $series->created_at = date("Y-m-d H:i:s");
            $series->updated_at = date("Y-m-d H:i:s");
            $series->id_user = $token->uid;
            $series->save();
            $rs = $resp->withStatus(201)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("une nouvelle serie a bien été crée"));
            return $rs;
        } else {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }


    public function insertPictureSeries(Request $req, Response $resp, array $args)
    {
        if ($series = series::find($args["id"])) {
            $series->series_pictures()->attach("43bd5288-65ef-4e58-9ebd-f19640ae43c9");
            $rs = $resp->withStatus(201)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("la photo a bien ete enregistre a cette serie."));
            return $rs;
        } else {
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("la serie n'existe pas"));
            return $rs;
        }
    }


    public function updateSerie(Request $req, Response $resp, array $args)
    {
        if (!$req->getAttribute('errors')) {
            $series = series::findOrFail($args["id"]);
            $getParsedBody = $req->getParsedBody();
            $series->city = filter_var($getParsedBody["city"], FILTER_SANITIZE_STRING);
            $series->distance = filter_var($getParsedBody["distance"], FILTER_SANITIZE_NUMBER_INT);
            $series->latitude = filter_var($getParsedBody["latitude"], FILTER_SANITIZE_STRING);
            $series->longitude = filter_var($getParsedBody["longitude"], FILTER_SANITIZE_STRING);
            $series->zoom = filter_var($getParsedBody["zoom"], FILTER_SANITIZE_NUMBER_INT);
            $series->nb_pictures = filter_var($getParsedBody["nb_pictures"], FILTER_SANITIZE_NUMBER_INT);
            $series->updated_at = date("Y-m-d H:i:s");
            $series->save();
            $rs = $resp->withStatus(201)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("la serie a bien été mise a jour"));
            return $rs;
        } else {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }

    public function updatePicture(Request $req, Response $resp, array $args)
    {
        if (!$req->getAttribute('errors')) {
            if ($pictures = picture::find($args["id"])) {
                $getParsedBody = $req->getParsedBody();
                $pictures->description = filter_var($getParsedBody["description"], FILTER_SANITIZE_STRING);
                $pictures->latitude = filter_var($getParsedBody["latitude"], FILTER_SANITIZE_STRING);
                $pictures->longitude = filter_var($getParsedBody["longitude"], FILTER_SANITIZE_STRING);
                $pictures->link = filter_var($getParsedBody["link"], FILTER_VALIDATE_URL);
                $pictures->save();
                $rs = $resp->withStatus(201)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode("la photo a bien été mise a jour"));
                return $rs;
            } else {
                $rs = $resp->withStatus(401)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode("Pas de photos correspondantes à cette id"));
                return $rs;
            }
        } else {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }

}
