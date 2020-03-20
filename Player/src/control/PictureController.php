<?php
namespace GeoQuizz\Player\control;

use GeoQuizz\Player\commons\writers\JSON;
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

            return JSON::successResponse($response, 200, [
                "type" => "resources",
                "pictures" => $pictures
            ]);
        } catch (ModelNotFoundException $exception) {
            return JSON::errorResponse($response, 404, "Series with ID ".$args['id']." not found.");
        }
    }
}