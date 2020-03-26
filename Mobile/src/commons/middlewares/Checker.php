<?php
namespace GeoQuizz\Mobile\commons\middlewares;

use GeoQuizz\Mobile\commons\writers\JSON;
use GeoQuizz\Mobile\model\Picture;
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

    public function pictureExists(Request $request, Response $response, callable $next) {
        $picture_id = isset($request->getAttribute('routeInfo')[2]['id']) ? $request->getAttribute('routeInfo')[2]['id'] : $request->getAttribute('routeInfo')[2]['id_picture'];

        try {
            $picture = Picture::query()->where('id', '=', $picture_id)->firstOrFail();
            $request = $request->withAttribute('picture', $picture);

            return $next($request, $response);
        } catch (ModelNotFoundException $exception) {
            return JSON::errorResponse($response, 404, "Picture with ID ".$picture_id." doesn't exist.");
        }
    }

    public function seriesExist(Request $request, Response $response, callable $next) {
        $series = $request->getParsedBody()['series'];

        try {
            foreach ($series as $seriesId) {
                Series::query()->where('id', '=', $seriesId)->firstOrFail();
            }
            $request = $request->withAttribute('series', $series);

            return $next($request, $response);
        } catch (ModelNotFoundException $exception) {
            return JSON::errorResponse($response, 404, "At least one of the series was not found.");
        }
    }
}