<?php
namespace GeoQuizz\Player\control;

use GeoQuizz\Player\commons\writers\URL;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GeoQuizz\Player\commons\writers\JSON;
use GeoQuizz\Player\model\Series;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SeriesController {
    protected $container;

    public function __construct(\Slim\Container $container = null) {
        $this->container = $container;
    }

    /**
     * @api {get} /series/ Liste
     * @apiGroup Series
     *
     * @apiDescription Récupère toutes les Series.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "type": "resources",
     *       "links": {
     *         "one_series": {
     *           "href": "http://api.player.local:19180/series/18d0eca6-756a-4e3b-9dde-e7a664f562cc/"
     *         }
     *       },
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
     */
    public function getSeries(Request $request, Response $response, $args) {
        $series = Series::query()
            ->join('series_pictures', 'series.id', '=', 'series_pictures.id')
            ->groupBy('series.id')
            ->havingRaw('COUNT(*)>= series.nb_pictures')
            ->get();

        return JSON::successResponse($response, 200, [
            "type" => "resources",
            "links" => [
                "one_series" => ["href" => URL::getRequestEndpoint($request)."/18d0eca6-756a-4e3b-9dde-e7a664f562cc/"]
            ],
            "series" => $series
        ]);
    }

    /**
     * @api {get} /series/:id/ Obtenir
     * @apiGroup Series
     *
     * @apiDescription Récupère une Series.
     *
     * @apiParam {String} id Le UUID de la Series.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "type": "resource",
     *       "links": {
     *         "pictures": {
     *           "href": "http://api.player.local:19180/series/18d0eca6-756a-4e3b-9dde-e7a664f562cc/pictures/"
     *         },
     *         "all_series": {
     *           "href": "http://api.player.local:19180/series/"
     *         }
     *       },
     *       "series": {
     *         "id": "18d0eca6-756a-4e3b-9dde-e7a664f562cc",
     *         "city": "Nancy",
     *         "distance": 100,
     *         "latitude": "38",
     *         "longitude": "53",
     *         "zoom": 7,
     *         "nb_pictures": 2,
     *         "created_at": "2020-03-20 00:25:29",
     *         "updated_at": "2020-03-20 00:25:29",
     *         "id_user": "18d0eca6-756a-4e3b-9dde-e7a664f562cc"
     *       }
     *     }
     *
     * @apiError SeriesNotFound Le UUID de la Series n'a pas été trouvé.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 NOT FOUND
     *     {
     *       "type": "error",
     *       "error": 404,
     *       "message": "Series with ID 18d0eca6-756a-484b-9dde-e7ab64f562cc not found."
     *     }
     */
    public function getSeriesWithId(Request $request, Response $response, $args) {
        try {
            $series = Series::query()->where('id', '=', $args['id'])->firstOrFail();

            return JSON::successResponse($response, 200, [
                "type" => "resource",
                "links" => [
                    "pictures" => ["href" => URL::getRequestEndpoint($request)."/pictures/"],
                    "all_series" => ["href" => substr(URL::getRequestEndpoint($request), 0, -(strlen($args['id'])))]
                ],
                "series" => $series
            ]);
        } catch (ModelNotFoundException $exception) {
            return JSON::errorResponse($response, 404, "Series with ID ".$args['id']." not found.");
        }
    }

    /**
     * @api {get} /series/:id/pictures/ Photos
     * @apiGroup Series
     *
     * @apiDescription Récupère les photos d'une Series.
     *
     * @apiParam {String} id Le UUID de la Series.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "type": "resources",
     *       "links": {
     *         "series": {
     *           "href": "http://api.player.local:19180/series/18d0eca6-756a-4e3b-9dde-e7a664f562cc/"
     *         },
     *         "all_series": {
     *           "href": "http://api.player.local:19180/series/"
     *         }
     *       },
     *       "pictures": [
     *         {
     *           "id": "18d0eca6-756a-4e3b-9dde-e7a664f562cc",
     *           "description": "photo 1",
     *           "latitude": "25",
     *           "longitude": "35",
     *           "link": "http://www.example.fr/photo1.png",
     *           "created_at": "2020-03-20 00:25:29",
     *           "updated_at": "2020-03-20 00:25:29",
     *           "id_user": "18d0eca6-756a-4e3b-9dde-e7a664f562cc"
     *         },
     *         {
     *           "id": "18d02ca6-746a-4e3b-9dfe-e7h664f562cc",
     *           "description": "photo 2",
     *           "latitude": "24",
     *           "longitude": "35",
     *           "link": "http://www.example.fr/photo2.png",
     *           "created_at": "2020-03-20 00:25:29",
     *           "updated_at": "2020-03-20 00:25:29",
     *           "id_user": "18d0eca6-756a-4e3b-9dde-e7a664f562cc"
     *         }
     *       ]
     *     }
     *
     * @apiError SeriesNotFound Le UUID de la Series n'a pas été trouvé.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 NOT FOUND
     *     {
     *       "type": "error",
     *       "error": 404,
     *       "message": "Series with ID 18d0eca6-756a-484b-9dde-e7ab64f562cc not found."
     *     }
     */
    public function getPicturesOfOneSeries(Request $request, Response $response, $args) {
        try {
            $series = Series::query()->where('id', '=', $args['id'])->firstOrFail();
            $pictures = $series->pictures()->inRandomOrder()->limit($series->nb_pictures)->get();

            foreach ($pictures as $picture) {
                unset($picture->pivot);
            }

            return JSON::successResponse($response, 200, [
                "type" => "resources",
                "links" => [
                    "series" => ["href" => substr(URL::getRequestEndpoint($request), 0, -(strlen('pictures')))],
                    "all_series" => ["href" => substr(URL::getRequestEndpoint($request), 0, -(strlen($args['id']) + strlen('pictures') + 1))]
                ],
                "pictures" => $pictures
            ]);
        } catch (ModelNotFoundException $exception) {
            return JSON::errorResponse($response, 404, "Series with ID ".$args['id']." not found.");
        }
    }
}