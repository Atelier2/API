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

    /**
     * @api {post} http://api.backoffice.local:19280/user/signup se connecter avec un membre.
     * @apiName userSignup
     * @apiGroup User
     * @apiHeader {String} BasicAuth  user_email  & user_password.
     * @apiSuccess {String} JWT token de session.
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkuYmFja29mZmljZS5sb2NhbCIsImF1ZCI6Imh0dHA6XC9cL2FwaS5iYWNrb2ZmaWNlLmxvY2FsIiwiaWF0IjoxNTg0ODc0NjY4LCJleHAiOjE1ODQ4NzgyNjgsInVpZCI6ImRlYWFjMGE5LTE5ZmEtNDU2OS05YzNjLTZkNDk4N2EyZDJhMCIsImx2bCI6MX0.UzEOK9IdobzxZboV9JNa6nYHXWNRv7dpANYYq1GFJMfxqzMTyk3N-f60k1FGNyk1GwU5PLwGcHSSHNIRM3VZwA"
     *     }
     */
    public function userSignin(Request $req, Response $resp, array $args)
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
                $rs = $resp->withStatus(400)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode('email ou mot de passe incorrect'));
                return $rs;
            }
        } else {
            $rs = $resp->withStatus(404)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode('aucun compte ne correspond à cette adresse email'));
            return $rs;
        }
    }

    /**
     * @api {post} http://api.backoffice.local:19280/user/signin Creer un membre.
     * @apiName userSignin
     * @apiGroup User
     * @apiExample {curl} Example usage:
     *     curl -X POST http://api.backoffice.local:19280/user/signin
     * @apiParam {String} firstname Le prenom du membre.
     * @apiParam {String} lastname Le nom du membre.
     * @apiParam {String} email l'addresse email du membre.
     * @apiParam {String} password Le mot de passe.
     * @apiParam {String} phone Le numero de telephone du memebre.
     * @apiParam {Number} street_number Le numero de la rue.
     * @apiParam {String} street Le nom de la rue.
     * @apiParam {String} city Le nom de la ville.
     * @apiParam {Number} zip_code Le code postal.
     * @apiParamExample {json} Request-Example:
     *     {
     * "firstname": "test",
     * "lastname": "test",
     * "email": "test@gmail.com",
     * "password": "test",
     * "phone": "0612345678",
     * "street_number": 23,
     * "street": "rue de la paix",
     * "city": "Paris",
     * "zip_code": 75000
     * }
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "votre compte utilisateur a bien été crée"
     *     }.
     */
    public function userSignup(Request $req, Response $resp, array $args)
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
            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("votre compte utilisateur a bien été crée"));
            return $rs;
        } else {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }

    /**
     * @api {post} http://api.backoffice.local:19280/series Creer une Serie.
     * @apiName insertSerie
     * @apiGroup Serie
     * @apiExample {curl} Example usage:
     *  curl -X POST http://api.backoffice.local:19280/series
     * @apiHeader {String} BearerToken  JWT de l'utilisateur connecte.
     * @apiParam {String} City La ville de la serie.
     * @apiParam {Number} Distance De la serie.
     * @apiParam {String} Latitude coordonnées gps latitude.
     * @apiParam {String} Longitude coordonnées gps longitude.
     * @apiParam {Number} Zoom l'indice de zoom.
     * @apiParam {Number} nb_pictures Le nombre de photos associe à cette série.
     * @apiParamExample {json} Request-Example:
     *     {
     *        "city" : "Paris",
     * "distance" : 1000,
     * "latitude" : "48.8566° N",
     * "longitude" : "2.3522° E",
     * "zoom" : 7,
     * "nb_pictures" : 4
     *     }
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "une nouvelle serie a bien été crée"
     *     }
     */

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
            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("une nouvelle serie a bien été crée"));
            return $rs;
        } else {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }

    /**
     * @api {post} http://api.backoffice.local:19280/picture Envoyer une photo.
     * @apiName insertPicture
     * @apiGroup Picture
     * @apiExample {curl} Example usage:
     *  curl -X POST http://api.backoffice.local:19280/picture
     * @apiHeader {String} BearerToken  JWT de l'utilisateur connecte.
     * @apiParam {String} Description description de la photo.
     * @apiParam {String} Latitude coordonnées gps latitude.
     * @apiParam {String} Longitude coordonnées gps longitude.
     * @apiParam {URL} Link liens de la photo vers Clodinary.
     * @apiParamExample {json} Request-Example:
     *     {
     * "description" : "Tour Eiffel",
     * "latitude" : "48.8584° N",
     * "longitude" : "2.2945° E",
     * "link" : "https://www.w3schools.com/php/filter_sanitize_url.asp"
     *     }
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "la photo a bien été ajoutee"
     *     }
     */
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
            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("la photo a bien été enregistré"));
            return $rs;
        } else {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }

    /**
     * @api {post} http://api.backoffice.local:19280/series/{id}/pictures Associer des photos a des series.
     * @apiName seriesPictures
     * @apiGroup Series
     * @apiExample {curl} Example usage:
     *     curl -X POST http://api.backoffice.local:19280/series/53e5def2-63ee-4531-ac9f-d12a80af9247/pictures
     * @apiHeader {String} BearerToken  JWT de l'utilisateur connecte.
     * @apiParam {Number} Id id de la série a associé.
     * @apiParam {Array} Pictures Tableau contenant les Ids des photos a associé.
     * @apiParamExample {json} Request-Example:
     *      {
     * "pictures": [{
     * "id": "3a192e17-e853-41af-80b7-c457e860e166"
     * },
     * {
     * "id": "6770cc1c-49dc-48e0-8822-5ce6e72151f9"
     * }
     * ]
     * }
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "les photos ont bien été associées à cette série."
     *     }
     */
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
                        $rs = $resp->withStatus(400)
                            ->withHeader('Content-Type', 'application/json;charset=utf-8');
                        $rs->getBody()->write(json_encode($picture["id"] . " " . "cette photo ne peut pas etre associées à cette série car son id n'existe pas"));
                        return $rs;
                    }
                }
                $rs = $resp->withStatus(200)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode("les photos ont bien été associées à cette série."));
                return $rs;
            } else {
                $rs = $resp->withStatus(404)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode("cette serie n'existe pas"));
                return $rs;
            }
        } else {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }

    /**
     * @api {put} http://api.backoffice.local:19280/series/{id} Modifier une Serie.
     * @apiName updateSerie
     * @apiGroup Serie
     * @apiExample {curl} Example usage:
     *  curl -X PUT http://api.backoffice.local:19280/series/5451d518-6863-409b-af77-0c29119b931c
     * @apiHeader {String} BearerToken  JWT de l'utilisateur connecte.
     * @apiParam {Number} Id id de la série a modifié.
     * @apiParam {String} City La ville de la serie.
     * @apiParam {Number} Distance De la serie.
     * @apiParam {String} Latitude coordonnées gps latitude.
     * @apiParam {String} Longitude coordonnées gps longitude.
     * @apiParam {Number} Zoom l'indice de zoom.
     * @apiParam {Number} nb_pictures Le nombre de photos associe à cette série.
     * @apiParamExample {json} Request-Example:
     *     {
     *        "city" : "Bordeaux",
     * "distance" : 1000,
     * "latitude" : "44.8378° N",
     * "longitude" : "0.5792° W",
     * "zoom" : 7,
     * "nb_pictures" : 7
     *     }
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "la serie a bien été modifie"
     *     }
     */
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
            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("la serie a bien été mise a jour"));
            return $rs;
        } else {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }

    /**
     * @api {put} http://api.backoffice.local:19280/picture/{id} Modifier une photo.
     * @apiName updatePicture
     * @apiGroup Picture
     * @apiExample {curl} Example usage:
     *  curl -X PUT http://api.backoffice.local:19280/picture/3a192e17-e853-41af-80b7-c457e860e166
     * @apiHeader {String} BearerToken  JWT de l'utilisateur connecte.
     * @apiParam {Number} Id id de la photo a modifié.
     * @apiParam {String} Description description de la photo.
     * @apiParam {String} Latitude coordonnées gps latitude.
     * @apiParam {String} Longitude coordonnées gps longitude.
     * @apiParam {URL} Link liens de la photo vers Clodinary.
     * @apiParamExample {json} Request-Example:
     *     {
     * "description" : "Arc de Triomphe",
     * "latitude" : "48.8738° N",
     * "longitude" : "2.2950° E",
     * "link" : "https://www.w3schools.com/php/filter_sanitize_url.asp"
     *     }
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "la photo a bien été modifiee"
     *     }
     */
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
                $rs = $resp->withStatus(200)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode("la photo a bien été mise a jour"));
                return $rs;
            } else {
                $rs = $resp->withStatus(400)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode("Pas de photos correspondantes à cette id"));
                return $rs;
            }
        } else {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }

}
