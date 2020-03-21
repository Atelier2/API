<?php

namespace GeoQuizz\Mobile\control;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GeoQuizz\Mobile\model\Serie as serie;
use GeoQuizz\Mobile\model\Picture as picture;
use Firebase\JWT\JWT;
use Ramsey\Uuid\Uuid;

class MobileController
{
    protected $c;

    public function __construct(\Slim\Container $c = null)
    {
        $this->c = $c;
    }

    public function addPicture(Request $req, Response $resp, array $args)
    {
        if ($req->getAttribute('errors')) {
            $token = "1254AFREDZZé";
            //$token = $req->getAttribute("token");
            $picture = new picture();
            $getParsedBody = $req->getParsedBody();
            $picture->id = Uuid::uuid4();
            $picture->description = filter_var($getParsedBody["description"], FILTER_SANITIZE_STRING);
            $picture->latitude = filter_var($getParsedBody["latitude"], FILTER_SANITIZE_STRING);
            $picture->longitude = filter_var($getParsedBody["longitude"], FILTER_SANITIZE_STRING);
            $picture->link = filter_var($getParsedBody["link"], FILTER_VALIDATE_URL);
            $picture->id_user = $token;
            $picture->save();
            $rs = $resp->withStatus(201)
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

    public function createSerie(Request $req, Response $resp, array $args)
    {
        if (!$req->getAttribute('errors')) {
            $token = "1254AFREDZZé";
            //$token = $req->getAttribute("token");
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
            $series->id_user = $token;
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

    public function getSerieId(Request $req, Response $resp, array $args)
    {
        try {
            $id = $args['id'];

            $serie = serie::findOrFail($id);

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
}
