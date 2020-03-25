<?php
namespace GeoQuizz\Mobile\commons\middlewares;

use GeoQuizz\Mobile\commons\writers\JSON;
use GeoQuizz\Mobile\model\Series;
use GeoQuizz\Mobile\model\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Checker {
    public function userExists(Request $request, Response $response, callable $next) {
        $user_id = isset($request->getAttribute('routeInfo')[2]['id']) ? $request->getAttribute('routeInfo')[2]['id'] : $request->getAttribute('routeInfo')[2]['id_user'];

        try {
            $user = User::query()->where('id', '=', $user_id)->firstOrFail();
            $request = $request->withAttribute('user', $user);

            return $next($request, $response);
        } catch (ModelNotFoundException $exception) {
            return JSON::errorResponse($response, 404, "User with ID ".$user_id." doesn't exist.");
        }
    }

    public function seriesExists(Request $request, Response $response, callable $next) {
        $series_id = isset($request->getAttribute('routeInfo')[2]['id']) ? $request->getAttribute('routeInfo')[2]['id'] : $request->getAttribute('routeInfo')[2]['id_series'];

        try {
            $series = Series::query()->where('id', '=', $series_id)->firstOrFail();
            $request = $request->withAttribute('series', $series);

            return $next($request, $response);
        } catch (ModelNotFoundException $exception) {
            return JSON::errorResponse($response, 404, "Series with ID ".$series_id." doesn't exist.");
        }
    }
}