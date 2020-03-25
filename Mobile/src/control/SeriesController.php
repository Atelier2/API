<?php
namespace GeoQuizz\Mobile\control;

use GeoQuizz\Mobile\commons\writers\JSON;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GeoQuizz\Mobile\model\Series;
use Ramsey\Uuid\Uuid;

class SeriesController {
    protected $container;

    public function __construct(\Slim\Container $container = null) {
        $this->container = $container;
    }

    /**
     * @api {get} https://api.mobile.local.19343/users/:id/series/ Liste
     * @apiGroup Series
     *
     * @apiDescription Récupère les Series d'un User.
     *
     * @apiHeader {String} Authorization Le token du User.
     *
     * @apiHeaderExample {json} Bearer Token:
     *     {
     *       "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA"
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "type": "resources",
     *       "series": [
     *         {
     *           "id": "18d0eca6-756a-4e3b-9dde-e7a664f562cc",
     *           "city": "Nancy",
     *           "distance": 100,
     *           "latitude": "38",
     *           "longitude": "53",
     *           "zoom": 7,
     *           "nb_pictures": 2,
     *           "created_at": "2020-03-20 00:25:29",
     *           "updated_at": "2020-03-20 00:25:29",
     *           "id_user": "18d0eca6-756a-4e3b-9dde-e7a664f562cc"
     *         },
     *         {
     *           "id": "18d0eca6-756a-4e3b-9dde-e7a664f562cc",
     *           "city": "Paris",
     *           "distance": 80,
     *           "latitude": "52",
     *           "longitude": "65",
     *           "zoom": 9,
     *           "nb_pictures": 7,
     *           "created_at": "2020-03-21 00:25:29",
     *           "updated_at": "2020-03-21 00:25:29",
     *           "id_user": "18d0eca6-756a-4e3b-9dde-e7a664f562cc"
     *         }
     *       ]
     *     }
     *
     * @apiError UserNotFound Le UUID ne correspond à aucun User.
     * @apiError InvalidToken Le Token du User est invalide, il doit se reconnecter.
     *
     * @apiErrorExample UserNotFound-Response:
     *     HTTP/1.1 404 NOT FOUND
     *     {
     *       "type": "error",
     *       "error": 404,
     *       "message": "User with ID db0913fa-934b-4981-9280-dc3bed19adb3 doesn't exist."
     *     }
     * @apiErrorExample InvalidToken-Response:
     *     HTTP/1.1 401 UNAUTHORIZED
     *     {
     *       "type": "error",
     *       "error": 401,
     *       "message": "Token expired."
     *     }
     */
    public function getSeries(Request $request, Response $response, $args) {
        $series = Series::query()->where('id_user', '=', $args['id'])->get();

        return JSON::successResponse($response, 200, [
            "type" => "resources",
            "series" => $series
        ]);
    }

    /**
     * @api {post} https://api.mobile.local.19343/users/:id/series/ Créer
     * @apiGroup Series
     *
     * @apiDescription Crée une Series pour un User.
     *
     * @apiParam {String} city Le nom de ville de la Series.
     * @apiParam {Number} distance Le marge d'erreur sur la précision de la Series.
     * @apiParam {Number} latitude La latitude de la Series.
     * @apiParam {Number} longitude La longitude de la Series.
     * @apiParam {Number} zoom Le zoom de la carte de la Series.
     * @apiParam {Mumber} nb_pictures Le nombre d'images dans la Series.
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "city": "Nancy",
     *       "distance": 100,
     *       "latitude": "38",
     *       "longitude": "53",
     *       "zoom": 7,
     *       "nb_pictures": 2
     *     }
     *
     * @apiHeader {String} Authorization Le token du User.
     *
     * @apiHeaderExample {json} Bearer Token:
     *     {
     *       "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA"
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 201 CREATED
     *     {
     *       "type": "resources",
     *       "series": {
     *         "id": "18d07ca6-7562-4a3b-9d9e-e7a264f562cc",
     *         "city": "Nancy",
     *         "distance": 100,
     *         "latitude": "38",
     *         "longitude": "53",
     *         "zoom": 7,
     *         "nb_pictures": 2,
     *         "created_at": "2020-03-20 00:25:29",
     *         "updated_at": "2020-03-20 00:25:29",
     *         "id_user": "18d0eca6-756a-4e3b-9dde-e7a664f562cc"
     *       },
     *     }
     *
     * @apiError UserNotFound Le UUID ne correspond à aucun User.
     * @apiError InvalidToken Le Token du User est invalide, il doit se reconnecter.
     *
     * @apiErrorExample UserNotFound-Response:
     *     HTTP/1.1 404 NOT FOUND
     *     {
     *       "type": "error",
     *       "error": 404,
     *       "message": "User with ID db0913fa-934b-4981-9280-dc3bed19adb3 doesn't exist."
     *     }
     * @apiErrorExample InvalidToken-Response:
     *     HTTP/1.1 401 UNAUTHORIZED
     *     {
     *       "type": "error",
     *       "error": 401,
     *       "message": "Token expired."
     *     }
     */
    public function createSeries(Request $request, Response $response, $args) {
        $body = $request->getParsedBody();

        try {
            $series = new Series();
            $series->id = Uuid::uuid4();
            $series->city = $body['city'];
            $series->distance = $body['distance'];
            $series->latitude = $body['latitude'];
            $series->longitude = $body['longitude'];
            $series->zoom = $body['zoom'];
            $series->nb_pictures = $body['nb_pictures'];
            $series->id_user = $args['id'];
            $series->saveOrFail();

            return JSON::successResponse($response, 201, [
                "type" => "resource",
                "series" => $series
            ]);
        } catch (\Throwable $exception) {
            return JSON::errorResponse($response, 500, "The series creation failed.");
        }
    }
}