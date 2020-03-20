<?php
namespace GeoQuizz\Player\control;

use GeoQuizz\Player\commons\Writers\Writer;
use GeoQuizz\Player\model\Game;
use GeoQuizz\Player\model\Series;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PictureController {
    protected $container;

    public function __construct(\Slim\Container $container = null) {
        $this->container = $container;
    }

    public function getPicturesOfOneSeries(Request $request, Response $response, $args) {
        try {
            $series = Series::query()->where('id', '=', $args['id'])->firstOrFail();
            $pictures = $series->pictures()->inRandomOrder()->limit($series->nb_pictures)->get();

            $response = Writer::jsonResponse($response, 200, [
                "type" => "resources",
                "pictures" => $pictures
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