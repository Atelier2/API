<?php
namespace GeoQuizz\Player\control;

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

    public function getSeries(Request $request, Response $response, $args) {
        $series = Series::query()
            ->join('series_pictures', 'series.id', '=', 'series_pictures.id')
            ->groupBy('series.id')
            ->havingRaw('COUNT(*)>= series.nb_pictures')
            ->get();

        return JSON::successResponse($response, 200, [
            "type" => "resources",
            "series" => $series
        ]);
    }

    public function getSeriesWithId(Request $request, Response $response, $args) {
        try {
            $series = Series::query()->where('id', '=', $args['id'])->firstOrFail();

            return JSON::successResponse($response, 200, [
                "type" => "resource",
                "series" => $series
            ]);
        } catch (ModelNotFoundException $exception) {
            return JSON::errorResponse($response, 404, "Series with ID ".$args['id']." not found.");
        }
    }
}