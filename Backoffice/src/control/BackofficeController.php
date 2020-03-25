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
     * @api {post} http://api.backoffice.local:19280/user/signin se connecter avec un membre.
     * @apiName userSignin
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
        if ($user = user::where('email', '=', $user_email)->first() and password_verify($user_password, $user->password)) {
            $token = JWT::encode(
                ['iss' => 'http://api.backoffice.local',
                    'aud' => 'http://api.backoffice.local',
                    'iat' => time(),
                    'exp' => time() + 86400,
                    'uid' => $user->id,
                    'lvl' => 1],
                "secret", 'HS512');
            $expiration = array();
            $expiration["date"] = date('Y-m-d', time() + 86400);
            $expiration["time"] = date('H:i:s', time() + 86400);
            $user_data = array();
            $user_data["email"] = $user->email;
            $user_data["id"] = $user->id;
            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode([
                "token" => $token,
                "expiration" => $expiration,
                "user" => $user_data
            ]));
            return $rs;
        } else {
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode('email ou mot de passe incorrect'));
            return $rs;
        }
    }

    /**
     * @api {post} http://api.backoffice.local:19280/user/signup Creer un membre.
     * @apiName userSignup
     * @apiGroup User
     * @apiExample {curl} Example usage:
     *     curl -X POST http://api.backoffice.local:19280/user/signup
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
            $token = random_bytes(32);
            $token = bin2hex($token);
            $user->id = Uuid::uuid4();
            $user->token = $token;
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
            $rs->getBody()->write(json_encode(["email" => $user->email, "password" => $json["password"], "uuid" => $user->id]));
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
     * @apiParam {String} city La ville de la serie.
     * @apiParam {Number} distance De la serie.
     * @apiParam {String} latitude coordonnées gps latitude.
     * @apiParam {String} longitude coordonnées gps longitude.
     * @apiParam {Number} zoom l'indice de zoom.
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
            $rs->getBody()->write(json_encode(["series_uuid" => $series->id, "users_uuid" => $series->id_user, "date" => $series->created_at, "message" => "une nouvelle serie a bien ete cree"]));
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
     * @apiParam {String} description description de la photo.
     * @apiParam {String} latitude coordonnées gps latitude.
     * @apiParam {String} longitude coordonnées gps longitude.
     * @apiParam {URL} link liens de la photo vers Clodinary.
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
            $PictureArray = array();
            $PictureArray["id"] = $picture->id;
            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode(["pictures" => $PictureArray]));
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
        if ($series = series::find($args["id"])) {
            $token = $req->getAttribute("token");
            if ($series->id_user == $token->uid) {
                if (!$req->getAttribute('errors')) {
                    $getBody = $req->getBody();
                    $json = json_decode($getBody, true);
                    foreach ($json["pictures"] as $picture) {
                        if ($pictures = picture::find($picture["id"]) and $pictures->id_user == $token->uid) {
                            $series->series_pictures()->attach($picture["id"]);
                        } else {
                            echo "cette photo ne peut pas etre associe.";
                        }
                    }
                    $rs = $resp->withStatus(200)
                        ->withHeader('Content-Type', 'application/json;charset=utf-8');
                    $rs->getBody()->write(json_encode("les photos ont bien été associées à cette série."));
                    return $rs;
                } else {
                    $errors = $req->getAttribute('errors');
                    $rs = $resp->withStatus(400)
                        ->withHeader('Content-Type', 'application/json;charset=utf-8');
                    $rs->getBody()->write(json_encode($errors));
                    return $rs;
                }
            } else {
                $rs = $resp->withStatus(400)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode("vous ne pouvez pas associer  cette serie"));
                return $rs;
            }
        } else {
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("cette serie n'existe pas"));
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
     * @apiParam {Number} id id de la série a modifié.
     * @apiParam {String} city La ville de la serie.
     * @apiParam {Number} distance De la serie.
     * @apiParam {String} latitude coordonnées gps latitude.
     * @apiParam {String} longitude coordonnées gps longitude.
     * @apiParam {Number} zoom l'indice de zoom.
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
        $series = series::findOrFail($args["id"]);
        $token = $req->getAttribute("token");
        if ($series->id_user == $token->uid) {
            if (!$req->getAttribute('errors')) {
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
                $rs->getBody()->write(json_encode(["series_uuid" => $series->id, "users_uuid" => $series->id_user, "date" => $series->created_at, "message" => "la serie a bien ete modifie"]));
                return $rs;
            } else {
                $errors = $req->getAttribute('errors');
                $rs = $resp->withStatus(400)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode($errors));
                return $rs;
            }
        } else {
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("vous ne pouvez pas changer cette serie"));
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
     * @apiParam {Number} id id de la photo a modifié.
     * @apiParam {String} description description de la photo.
     * @apiParam {String} latitude coordonnées gps latitude.
     * @apiParam {String} longitude coordonnées gps longitude.
     * @apiParam {URL} link liens de la photo vers Clodinary.
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
        $token = $req->getAttribute("token");
        if ($pictures = picture::find($args["id"])) {
            if ($pictures->id_user == $token->uid) {
                if (!$req->getAttribute('errors')) {
                    $getBody = $req->getBody();
                    $json = json_decode($getBody, true);
                    $pictures->description = filter_var($json["description"], FILTER_SANITIZE_STRING);
                    $pictures->latitude = filter_var($json["latitude"], FILTER_SANITIZE_STRING);
                    $pictures->longitude = filter_var($json["longitude"], FILTER_SANITIZE_STRING);
                    $pictures->link = filter_var($json["link"], FILTER_VALIDATE_URL);
                    $pictures->save();
                    $rs = $resp->withStatus(200)
                        ->withHeader('Content-Type', 'application/json;charset=utf-8');
                    $rs->getBody()->write(json_encode(["pictures_uuid" => $pictures->id, "users_uuid" => $pictures->id_user, "date" => $pictures->updated_at, "message" => "la photo a bien ete modifie"]));
                    return $rs;
                } else {
                    $errors = $req->getAttribute('errors');
                    $rs = $resp->withStatus(400)
                        ->withHeader('Content-Type', 'application/json;charset=utf-8');
                    $rs->getBody()->write(json_encode($errors));
                    return $rs;
                }
            } else {
                $rs = $resp->withStatus(400)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode("vous ne pouvez pas modifier cette photo"));
                return $rs;
            }
        } else {
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("cette photo n'existe pas"));
            return $rs;
        }
    }

    /**
     * @api {get} http://api.backoffice.local:19280/series Récupérer toutes les series existantes.
     * @apiName getSeries
     * @apiGroup Serie
     * @apiExample {curl} Example usage:
     *  curl http://api.backoffice.local:19280/series
     * @apiHeader {String} BearerToken  JWT de l'utilisateur connecte.
     * @apiSuccessExample Success-Response:
     * {
     * "type": "collection",
     * "series": [
     * {
     * "id": "163effe5-b150-4e2d-8b65-91fef987dcb2",
     * "city": "test",
     * "distance": 2121,
     * "latitude": "test",
     * "longitude": "test",
     * "zoom": 7,
     * "nb_pictures": 4,
     * "created_at": "2020-03-21 13:22:55",
     * "updated_at": "2020-03-21 13:22:55",
     * "id_user": "d2b66cbc-a1f9-4e80-bb22-65b07455433c"
     * },
     * {
     * "id": "52e70cc6-68fe-4de3-ada3-e59c3c2b5f2f",
     * "city": "test",
     * "distance": 2121,
     * "latitude": "test",
     * "longitude": "test",
     * "zoom": 7,
     * "nb_pictures": 4,
     * "created_at": "2020-03-21 18:56:38",
     * "updated_at": "2020-03-21 18:56:38",
     * "id_user": "d2b66cbc-a1f9-4e80-bb22-65b07455433c"
     * }
     * ]
     * }
     */
    public function getSeries(Request $req, Response $resp, array $args)
    {
        $token = $req->getAttribute("token");
        $user = user::find($token->uid);
        $series = $user->getSeries()->get();
        $count_series = count($series);
        if ($count_series > 0) {
            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode(["type" => "collection", "series" => $series]));
            return $rs;
        } else {
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("vous n'avez aucunne serie"));
            return $rs;
        }
    }

    /**
     * @api {get} http://api.backoffice.local:19280/series/{id} Récupérer une serie existantes.
     * @apiName getSerie
     * @apiGroup Serie
     * @apiExample {curl} Example usage:
     *  curl http://api.backoffice.local:19280/series/163effe5-b150-4e2d-8b65-91fef987dcb2
     * @apiHeader {String} BearerToken  JWT de l'utilisateur connecte.
     * @apiParam {String}  id identifiant de la série recherchée.
     * @apiSuccessExample Success-Response:
     * {
     * "type": "collection",
     * "serie": {
     * "id": "163effe5-b150-4e2d-8b65-91fef987dcb2",
     * "city": "test",
     * "distance": 2121,
     * "latitude": "test",
     * "longitude": "test",
     * "zoom": 7,
     * "nb_pictures": 4,
     * "created_at": "2020-03-21 13:22:55",
     * "updated_at": "2020-03-21 13:22:55",
     * "id_user": "d2b66cbc-a1f9-4e80-bb22-65b07455433c"
     * }
     * }
     */
    public function getSerie(Request $req, Response $resp, array $args)
    {
        $id = $req->getAttribute("id");
        $token = $req->getAttribute("token");
        $user = user::find($token->uid);
        $serie = series::find($id);
        if ($user->id == $serie->id_user) {
            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode(["type" => "collection", "series" => $serie]));
            return $rs;
        } else {
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("vous ne pouvez pas voir cette serie"));
            return $rs;
        }
    }

    public function getPictures(Request $req, Response $resp, array $args)
    {
        $token = $req->getAttribute("token");
        $user = user::find($token->uid);
        $pictures = $user->getPictures()->get();
        $count_pictures = count($pictures);
        if ($count_pictures > 0) {
            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode(["type" => "collection", "pictures" => $pictures]));
            return $rs;
        } else {
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("vous n'avez aucunne photo"));
            return $rs;
        }
    }

    public function getPicture(Request $req, Response $resp, array $args)
    {
        $id = $req->getAttribute("id");
        $token = $req->getAttribute("token");
        $user = user::find($token->uid);
        if ($pictures = picture::find($id)) {
            if ($user->id == $pictures->id_user) {
                $rs = $resp->withStatus(200)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode(["type" => "collection", "pictures" => $pictures]));
                return $rs;
            } else {
                $rs = $resp->withStatus(400)
                    ->withHeader('Content-Type', 'application/json;charset=utf-8');
                $rs->getBody()->write(json_encode("vous ne pouvez pas voir cette photo"));
                return $rs;
            }
        } else {
            $rs = $resp->withStatus(400)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("cette photo n'existe pas"));
            return $rs;
        }
    }
}
