<?php
namespace GeoQuizz\Player\control;

use GeoQuizz\Player\commons\writers\JSON;
use GeoQuizz\Player\model\Game;
use GeoQuizz\Player\model\Series;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Uuid;
use Firebase\JWT\JWT;

class GameController {
    protected $container;

    public function __construct(\Slim\Container $container = null) {
        $this->container = $container;
    }

    /**
     * @api {get} /games/:id/ Obtenir
     * @apiGroup Games
     *
     * @apiDescription Récupère une Game.
     *
     * @apiParam {String} id Le UUID de la Game.
     *
     * @apiHeader {String} Authorization Le token de la game.
     *
     * @apiHeaderExample {json} Bearer Token:
     *     {
     *       "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA"
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "type": "resource",
     *       "game": {
     *         "id": "5a005636-4514-45cc-a6d5-496847b0adbf",
     *         "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA",
     *         "score": 0,
     *         "pseudo": "Albert Einstein",
     *         "id_status": 0,
     *         "id_series": "8d0eca6-756a-4e3b-9dde-e7a664f562cc"
     *       }
     *     }
     *
     * @apiError GameNotFound Le UUID de la Game n'a pas été trouvé.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "type": "error",
     *       "error": 404,
     *       "message": "Game with ID 5a005626-4514-45cc-a5d5-496847bdadbf not found."
     *     }
     */
    public function getGameWithId(Request $request, Response $response, $args) {
        try {
            $game = Game::query()->where('id', '=', $args['id'])->firstOrFail();

            return JSON::successResponse($response, 200, [
                "type" => "resource",
                "game" => $game
            ]);
        } catch (ModelNotFoundException $exception) {
            return JSON::errorResponse($response, 404, "Game with ID ".$args['id']." not found.");
        }
    }

    /**
     * @api {post} /games/ Créer
     * @apiGroup Games
     *
     * @apiDescription Crée une Game.
     *
     * @apiParam {String} username Le pseudo du joueur.
     * @apiParam {String} id_series Le UUID de la Series.
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "username": "Albert Einstein",
     *       "id_series": "8d0eca6-756a-4e3b-9dde-e7a664f562cc"
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 201 CREATED
     *     {
     *       "type": "resource",
     *       "game": {
     *         "id": "5a005636-4514-45cc-a6d5-496847b0adbf",
     *         "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA",
     *         "score": 0,
     *         "pseudo": "Albert Einstein",
     *         "id_status": 0,
     *         "id_series": "8d0eca6-756a-4e3b-9dde-e7a664f562cc"
     *       }
     *     }
     *
     * @apiError SeriesNotFound Le UUID de la Series n'a pas été trouvé.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "type": "error",
     *       "error": 404,
     *       "message": "Series with ID 8d0eca6-756a-433b-9dde-e7ad64f562cc not found."
     *     }
     */
    public function createGame(Request $request, Response $response, $args) {
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

                return JSON::successResponse($response, 201, [
                    "type" => "resource",
                    "game" => $game
                ]);
            } catch (ModelNotFoundException $exception) {
                return JSON::errorResponse($response, 404, "Series with ID ".$body['id_series']." not found.");

            } catch (\Throwable $exception) {
                return JSON::errorResponse($response, 500, "The creation of the game failed.");

            }
        } else {
            return JSON::errorResponse($response, 400, "At least one of the fields is empty. Fields 'username' and 'id_series' must be provided.");
        }
    }

    /**
     * @api {put} /games/:id/ Modifier
     * @apiGroup Games
     *
     * @apiDescription Modifie une Game existante.
     *
     * @apiParam {String} id Le UUID de la Game.
     * @apiParam {number} [score] Le nouveau score de la Game.
     * @apiParam {number=0,1,2} [id_status] Le nouveau status de la Game.
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "score": 1000,
     *       "id_status": 1
     *     }
     *
     * @apiHeader {String} Authorization Le token de la game.
     *
     * @apiHeaderExample {json} Bearer Token:
     *     {
     *       "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA"
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "type": "resource",
     *       "game": {
     *         "id": "5a005636-4514-45cc-a6d5-496847b0adbf",
     *         "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA",
     *         "score": 1000,
     *         "pseudo": "Albert Einstein",
     *         "id_status": 1,
     *         "id_series": "8d0eca6-756a-4e3b-9dde-e7a664f562cc"
     *       }
     *     }
     *
     * @apiError GameNotFound Le UUID de la Game n'a pas été trouvé.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "type": "error",
     *       "error": 404,
     *       "message": "Game with ID 5a005636-4514-45cc-a6d5-496847b0adbf not found."
     *     }
     */
    public function updateGame(Request $request, Response $response, $args) {
        $body = $request->getParsedBody();

        try {
            $game = Game::query()->where('id', '=', $args['id'])->firstOrFail();

            $game->score = isset($body['score']) ? $body['score'] : $game->score;
            $game->id_status = isset($body['id_status']) ? $body['id_status'] : $game->id_status;
            $game->saveOrFail();

            return JSON::successResponse($response, 200, [
                "type" => "resource",
                "game" => $game
            ]);
        } catch (ModelNotFoundException $exception) {
            return JSON::errorResponse($response, 404, "Game with ID ".$args['id']." not found.");

        } catch (\Throwable $exception) {
            return JSON::errorResponse($response, 500, "The update of the game failed. Error: ".$exception->getMessage());
        }
    }
}