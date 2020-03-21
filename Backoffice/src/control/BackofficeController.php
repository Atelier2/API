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
            $getBody = $req->getBody();
            $json = json_decode($getBody, true);
            $user->id = Uuid::uuid4();
            $user->token = "test";
            $user->firstname = filter_var($json["firstname"], FILTER_SANITIZE_STRING);
            $user->lastname = filter_var($json["lastname"], FILTER_SANITIZE_STRING);
            $user->email = filter_var($json["email"], FILTER_SANITIZE_EMAIL);
            $user->password = password_hash($json["password"], PASSWORD_DEFAULT);
            $user->phone = filter_var($json["phone"], FILTER_SANITIZE_NUMBER_INT);
            $user->street_number = filter_var($json["street_number"], FILTER_SANITIZE_NUMBER_INT);
            $user->street = filter_var($json["street"], FILTER_SANITIZE_STRING);
            $user->city = filter_var($json["city"], FILTER_SANITIZE_STRING);
            $user->zip_code = filter_var($json["zip_code"], FILTER_SANITIZE_STRING);
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
            $getBody = $req->getBody();
            $json = json_decode($getBody, true);
            $series->id = Uuid::uuid4();
            $series->city = filter_var($json["city"], FILTER_SANITIZE_STRING);
            $series->distance = filter_var($json["distance"], FILTER_SANITIZE_NUMBER_INT);
            $series->latitude = filter_var($json["latitude"], FILTER_SANITIZE_STRING);
            $series->longitude = filter_var($json["longitude"], FILTER_SANITIZE_STRING);
            $series->zoom = filter_var($json["zoom"], FILTER_SANITIZE_NUMBER_INT);
            $series->nb_pictures = filter_var($json["nb_pictures"], FILTER_SANITIZE_NUMBER_INT);
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


    public function insertPicture(Request $req, Response $resp, array $args)
    {
        if (!$req->getAttribute('errors')) {
            $token = $req->getAttribute("token");
            $picture = new picture();
            $getBody = $req->getBody();
            $json = json_decode($getBody, true);
            $picture->id = Uuid::uuid4();
            $picture->description = filter_var($json["description"], FILTER_SANITIZE_STRING);
            $picture->latitude = filter_var($json["latitude"], FILTER_SANITIZE_STRING);
            $picture->longitude = filter_var($json["longitude"], FILTER_SANITIZE_STRING);
            $picture->link = filter_var($json["link"], FILTER_VALIDATE_URL);
            $picture->id_user = $token->uid;
            $picture->save();
            $rs = $resp->withStatus(201)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("la photo a bien été enregistré"));
            return $rs;
        } else {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }


    public function seriesPictures(Request $req, Response $resp, array $args)
    {
        if (!$req->getAttribute('errors')) {
            if ($series = series::find($args["id"])) {
                $getBody = $req->getBody();
                $json = json_decode($getBody, true);
                foreach ($json["pictures"] as $picture) {
                    if (picture::find($picture["id"])) {
                        $series->series_pictures()->attach($picture["id"]);
                    } else {
                        $rs = $resp->withStatus(401)
                            ->withHeader('Content-Type', 'application/json;charset=utf-8');
                        $rs->getBody()->write(json_encode($picture["id"] . " " . "cette photo ne peut pas etre associées à cette série car son id n'existe pas"));
                        return $rs;
                    }
                }
                $rs = $resp->withStatus(201)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode("les photos ont bien été associées à cette série."));
                return $rs;
            } else {
                $rs = $resp->withStatus(401)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode("cette serie n'existe pas"));
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

    public function updateSerie(Request $req, Response $resp, array $args)
    {
        if (!$req->getAttribute('errors')) {
            $series = series::findOrFail($args["id"]);
            $getBody = $req->getBody();
            $json = json_decode($getBody, true);
            $series->city = filter_var($json["city"], FILTER_SANITIZE_STRING);
            $series->distance = filter_var($json["distance"], FILTER_SANITIZE_NUMBER_INT);
            $series->latitude = filter_var($json["latitude"], FILTER_SANITIZE_STRING);
            $series->longitude = filter_var($json["longitude"], FILTER_SANITIZE_STRING);
            $series->zoom = filter_var($json["zoom"], FILTER_SANITIZE_NUMBER_INT);
            $series->nb_pictures = filter_var($json["nb_pictures"], FILTER_SANITIZE_NUMBER_INT);
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
                $getBody = $req->getBody();
                $json = json_decode($getBody, true);
                $pictures->description = filter_var($json["description"], FILTER_SANITIZE_STRING);
                $pictures->latitude = filter_var($json["latitude"], FILTER_SANITIZE_STRING);
                $pictures->longitude = filter_var($json["longitude"], FILTER_SANITIZE_STRING);
                $pictures->link = filter_var($json["link"], FILTER_VALIDATE_URL);
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
