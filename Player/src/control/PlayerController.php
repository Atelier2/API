<?php
namespace GeoQuizz\Player\control;

use Firebase\JWT\JWT;
use GeoQuizz\Player\model\Game;
use GeoQuizz\Player\model\Series;
use GeoQuizz\Player\commons\Writers\Writer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Uuid;

class PlayerController {
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
                "message" => "No series was found. Error message: ".$exception->getMessage()
            ]);
        }

        return $response;
    }

    public function createGame(Request $request, Response $response, $args) {
        // TODO: token JWT and data validator
        $body = $request->getParsedBody();

        if (isset($body['username']) && isset($body['id_series'])) {
            try {
                Series::query()->where('id', '=', $body['id_series'])->firstOrFail();

                $game = new Game();
                $game->id = Uuid::uuid4();
                $game->token = JWT::encode([
                    "iss" => "api_player",
                    "sub" => "game",
                    "aud" => "player",
                    "iat" => time(), // Current timestamp
                    "exp" => time() + (3 * 60 * 60), // Current timestamp + 3 hours
                ], $this->container->settings['JWT_secret'], "HS512");
                $game->score = 0;
                $game->pseudo = $body['username'];
                $game->id_status = 0;
                $game->id_series = $body['id_series'];
                $game->saveOrFail();

                return Writer::jsonResponse($response, 201, [
                    "type" => "resource",
                    "game" => $game
                ]);
            } catch (ModelNotFoundException $exception) {
                return Writer::jsonResponse($response, 404, [
                    "type" => "error",
                    "error" => 404,
                    "message" => "Series with ID ".$body['id_series']." not found."
                ]);
            } catch (\Throwable $exception) {
                return Writer::jsonResponse($response, 500, [
                    "type" => "error",
                    "error" => 500,
                    "message" => "The creation of the game failed. Error message: ".$exception->getMessage()
                ]);
            }
        } else {
            return Writer::jsonResponse($response, 400, [
                "type" => "error",
                "error" => 400,
                "message" => "At least one of the fields is empty. Fields 'username' and 'id_status' must be provided."
            ]);
        }
    }
}
