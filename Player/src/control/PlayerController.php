<?php
namespace GeoQuizz\Player\control;

use GeoQuizz\Player\model\Series;
use GeoQuizz\Player\commons\Writers\Writer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PlayerController {
    protected $container;

    public function __construct(\Slim\Container $container = null) {
        $this->container = $container;
    }

    public static function getSeries(Request $request, Response $response, $args) {
        $series = Series::all();

        $response = Writer::jsonResponse($response, 200, [
            "type" => "resources",
            "series" => $series
        ]);

        return $response;
    }

    public static function getSeriesWithId(Request $request, Response $response, $args) {
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
                "message" => "No series was found. Error message: ".$exception->getMessage()
            ]);
        }

        return $response;
    }

    public static function createGame(Request $request, Response $response, $args) {
        // TODO: token JWT and data validator
    }
}
