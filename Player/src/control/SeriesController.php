<?php
namespace GeoQuizz\Player\control;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GeoQuizz\Player\commons\Writers\Writer;
use GeoQuizz\Player\model\Series;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SeriesController {
    protected $container;

    public function __construct(\Slim\Container $container = null) {
        $this->container = $container;
    }

    public function getSeries(Request $request, Response $response, $args) {
        $series = Series::all();

        $response = Writer::jsonResponse($response, 200, [
            "type" => "resources",
            "series" => $series
        ]);

        return $response;
    }

    public function getSeriesWithId(Request $request, Response $response, $args) {
        try {
            $series = Series::query()->where('id', '=', $args['id'])->firstOrFail();

            $response = Writer::jsonResponse($response, 200, [
                "type" => "resource",
                "series" => $series
            ]);
        } catch (ModelNotFoundException $exception) {
            $response = Writer::jsonResponse($response, 404, [
                "type" => "error",
                "error" => 404,
                "message" => "Series with ID ".$args['id']." not found."
            ]);
        }

        return $response;
    }
}