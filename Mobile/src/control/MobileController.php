<?php

namespace GeoQuizz\Mobile\control;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GeoQuizz\Mobile\model\Serie as serie;
use GeoQuizz\Mobile\model\Picture as picture;
use GeoQuizz\Mobile\model\User as user;
use Firebase\JWT\JWT;
use Ramsey\Uuid\Uuid;

class MobileController
{
    protected $c;

    public function __construct(\Slim\Container $c = null)
    {
        $this->c = $c;
    }

    /**
     * @api {post} http://api.mobile.local:19380/picture Ajouter une photo
     * @apiName addPicture
     * @apiGroup Pictures
     * @apiExample {curl} Example test:
     *  curl -X POST http://api.mobile.local:19380/picture
     * @apiHeader {String} BearerToken  JWT de l'utilisateur connecte.
     * @apiParam {String} Description description de la photo.
     * @apiParam {String} Latitude coordonnées gps latitude.
     * @apiParam {String} Longitude coordonnées gps longitude.
     * @apiParam {URL} Link liens de la photo vers Cloudinary.
     * @apiParamExample {json} Request-Example:
     *     {
     * "description" : "Place Stanislas",
     * "latitude" : "23.5487° E",
     * "longitude" : "5.2136° E",
     * "link" : "https://google.com"
     *     }
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "picture saved"
     *     }
     * 
     */
    public function addPicture(Request $req, Response $resp, array $args)
    {
        if ($req->getAttribute('errors')) {
            //$token = "1254AFREDZZé";
            $token = $req->getAttribute("token");
            $picture = new picture();
            $getParsedBody = $req->getParsedBody();
            $picture->id = Uuid::uuid4();
            $picture->description = filter_var($getParsedBody["description"], FILTER_SANITIZE_STRING);
            $picture->latitude = filter_var($getParsedBody["latitude"], FILTER_SANITIZE_STRING);
            $picture->longitude = filter_var($getParsedBody["longitude"], FILTER_SANITIZE_STRING);
            $picture->link = filter_var($getParsedBody["link"], FILTER_VALIDATE_URL);
            $picture->id_user = $token->uid;
            $picture->save();
            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode("Picture saved"));
            return $rs;
        } else {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }


   /**
     * @api {get} /picture Récupère toutes les photos
     * @apiName getPictures
     * @apiGroup Pictures
     *
     * @apiExample Example usage:
     * curl -i  http://api.mobile.local:19380/picture
     *
     * 
     * @apiSuccess {String} City Ville correspondant à la photo.
     * @apiSuccess {Number} Distance De la photo.
     * @apiSuccess {String} Latitude coordonnées gps latitude.
     * @apiSuccess {String} Longitude coordonnées gps longitude.
     * @apiSuccess {Number} Zoom l'indice de zoom.
     * @apiSuccess {String} Link Lien vers cloudinary.
     *
     */
    public function getPictures(Request $req, Response $resp, array $args)
    {
        try {
            $pictures = picture::all();

            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');

            $rs->getBody()->write(json_encode([
                "type" => "collection",
                "description"=>$pictures->description,
                "location" => [
                    "latitude"=>$pictures->latitude,
                    "longitude"=>$pictures->longitude], 
                "count" => $pictures->count(),
                "link" => $pictures->link]));

            return $rs;
        } catch (\Exception $e) {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }

    /**
     * @api {get} /picture/:id Récupère une photo
     * @apiName getPictureId
     * @apiGroup Pictures
     *
     * @apiExample Example usage:
     * curl -i  http://api.mobile.local:19380/picture/id
     *
     * @apiParam {String} id  ID de la photo.
     * 
     * @apiSuccess {String} City Ville correspondant à la photo.
     * @apiSuccess {Number} Distance De la photo.
     * @apiSuccess {String} Latitude coordonnées gps latitude.
     * @apiSuccess {String} Longitude coordonnées gps longitude.
     * @apiSuccess {Number} Zoom l'indice de zoom.
     * @apiSuccess {String} Link Lien vers cloudinary.
     *
     */

    public function getPictureId(Request $req, Response $resp, array $args)
    {
        try {
            $id = $args['id'];
            $token = $req->getAttribute('token');

            $picture = picture::findOrFail($id);

            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');

            $rs->getBody()->write(json_encode([
                "type" => "collection",
                "description"=>$picture->description,
                "location" => [
                    "latitude"=>$picture->latitude,
                    "longitude"=>$picture->longitude],
                "link" => $picture->link]));

            return $rs;
        } catch (\Exception $e) {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors, $e->getMessage()));
            return $rs;
        }   
    }

    /**
     * @api {post} http://api.mobile.local:19380/series Creer une Serie.
     * @apiName createSerie
     * @apiGroup Series
     * @apiExample {curl} Example:
     *  curl -X POST http://api.mobile.local:19380/series
     * @apiHeader {String} BearerToken  JWT de l'utilisateur connecte.
     * @apiParam {String} City La ville de la serie.
     * @apiParam {Number} Distance De la serie.
     * @apiParam {String} Latitude coordonnées gps latitude.
     * @apiParam {String} Longitude coordonnées gps longitude.
     * @apiParam {Number} Zoom l'indice de zoom.
     * @apiParam {Number} nb_pictures Le nombre de photos associe à cette série.
     * @apiParamExample {json} Request-Example:
     *     {
     *        "city" : "Nancy",
     * "distance" : 300,
     * "latitude" : "48.8566° N",
     * "longitude" : "2.3522° E",
     * "zoom" : 3,
     * "nb_pictures" : 2
     *     }
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "Nouvelle serie ajoutée"
     *     }
    */
    public function createSerie(Request $req, Response $resp, array $args)
    {
        if (!$req->getAttribute('errors')) {
            //$token = "1254AFREDZZé";
            $token = $req->getAttribute("token");
            $series = new serie();
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
            $rs->getBody()->write(json_encode("Nouvelle série ajoutée"));
            return $rs;
        } else {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }

    /**
     * @api {get} /series/:id Récupère une série
     * @apiName getSerieId
     * @apiGroup Series
     *
     * @apiExample Example usage:
     * curl -i  http://api.mobile.local:19380/series/id
     *
     * @apiParam {String} id  ID de la serie.
     * 
     * @apiSuccess {String} City Ville correspondant à la série.
     * @apiSuccess {Number} Distance De la serie.
     * @apiSuccess {String} Latitude coordonnées gps latitude.
     * @apiSuccess {String} Longitude coordonnées gps longitude.
     * @apiSuccess {Number} Zoom l'indice de zoom.
     * @apiSuccess {Number} nb_pictures Le nombre de photos associe à la série.
     *
     */

    public function getSerieId(Request $req, Response $resp, array $args)
    {
        try {
            $id = $args['id'];

            $serie = serie::firstOrFail($id);

            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');

            $rs->getBody()->write(json_encode([
                "type" => "collection",
                "ville"=>$series->city,
                "distance"=>$series->distance,
                "location" => [
                    "latitude"=>$series->latitude,
                    "longitude"=>$series->longitude], 
                "zoom" => $series->zoom,
                "nb_pictures" => $series->nb_pictures]));

            return $rs;
        } catch (\Exception $e) {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }

    /**
     * @api {get} /series/ Récupérer les séries
     * @apiName getSeries
     * @apiGroup Series
     *
     * @apiExample Example usage:
     * curl -i  http://api.mobile.local:19380/series
     *
     * @apiSuccess {String} id ID de la serie.
     * @apiSuccess {String} City Ville correspondant à la série.
     * @apiSuccess {Number} Distance De la serie.
     * @apiSuccess {String} Latitude coordonnées gps latitude.
     * @apiSuccess {String} Longitude coordonnées gps longitude.
     * @apiSuccess {Number} Zoom l'indice de zoom.
     * @apiSuccess {Number} nb_pictures Le nombre de photos associe à cette série.
     *
     */
    public function getSeries(Request $req, Response $resp, array $args)
    {
        try {
            $series = serie::all();

            $rs = $resp->withStatus(200)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');

            $rs->getBody()->write(json_encode([
                "type" => "collection",
                "ville"=>$series->city,
                "distance"=>$series->distance,
                "location" => [
                    "latitude"=>$series->latitude,
                    "longitude"=>$series->longitude], 
                "zoom" => $series->zoom,
                "nb_pictures" => $series->nb_pictures]));

            return $rs;
        } catch (\Exception $e) {
            $errors = $req->getAttribute('errors');
            $rs = $resp->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode($errors));
            return $rs;
        }
    }

    /**
     * @api {post} http://api.mobile.local:19280/user/signup Création d'un utilisateur.
     * @apiName userSignup
     * @apiGroup User
     * @apiExample {curl} Example usage:
     *     curl -X POST http://api.mobile.local:19380/user/signup
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
     * "firstname": "ok",
     * "lastname": "ok",
     * "email": "ok@gmail.com",
     * "password": "ok",
     * "phone": "06060606",
     * "street_number": 23,
     * "street": "rue des hibiscus",
     * "city": "Nancy",
     * "zip_code": 54000
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
            $getParsedBody = $req->getBody();
            $decode = json_decode($getParsedBody,true);
            $user->id = Uuid::uuid4();
            $user->token = "test";
            $user->firstname = filter_var($decode["firstname"], FILTER_SANITIZE_STRING);
            $user->lastname = filter_var($decode["lastname"], FILTER_SANITIZE_STRING);
            $user->email = filter_var($decode["email"], FILTER_SANITIZE_EMAIL);
            $user->password = password_hash($decode["password"], PASSWORD_DEFAULT);
            $user->phone = filter_var($decode["phone"], FILTER_SANITIZE_NUMBER_INT);
            $user->street_number = filter_var($decode["street_number"], FILTER_SANITIZE_NUMBER_INT);
            $user->street = filter_var($decode["street"], FILTER_SANITIZE_STRING);
            $user->city = filter_var($decode["city"], FILTER_SANITIZE_STRING);
            $user->zip_code = filter_var($decode["zip_code"], FILTER_SANITIZE_STRING);
            $user->created_at = date("Y-m-d H:i:s");
            $user->updated_at = date("Y-m-d H:i:s");
            $user->save();
            $rs = $resp->withStatus(201)
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
     * @api {post} http://api.mobile.local:19280/user/signin Se connecter.
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
        if ($user = user::where('email', '=', $user_email)->first()) {
            if (password_verify($user_password, $user->password)) {
                $token = JWT::encode(
                    ['iss' => 'http://api.mobile.local',
                        'aud' => 'http://api.mobile.local',
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
                $rs->getBody()->write(json_encode(['type' => 'error', 'Error_code' => 401, 'message :' => 'email ou mot de passe incorrect']));
                return $rs;
            }
        } else {
            $rs = $resp->withStatus(404)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $rs->getBody()->write(json_encode(['type' => 'error', 'Error_code' => 401, 'message :' => 'aucun compte ne correspond à cette adresse email']));
            return $rs;
        }
    }
}
