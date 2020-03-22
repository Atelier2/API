<?php
namespace GeoQuizz\Player\commons\middlewares;

use GeoQuizz\Player\commons\writers\JSON;
use Respect\Validation\Validator as RespectValidator;
use DavidePastore\Slim\Validation\Validation;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Validator {
    public static function updateGameValidator() {
        $validator =  [
            'score' => RespectValidator::optional(RespectValidator::intVal()->positive()),
            'id_status' => RespectValidator::optional(RespectValidator::intVal()->positive()->between(0,2))
        ];

        return new Validation($validator);
    }

    public static function createGameValidator() {
        $validator = [
            'username' => RespectValidator::alnum(),
            'id_series' => RespectValidator::alnum('-')
        ];

        return new Validation($validator);
    }

    public static function getLeaderboardValidator() {
        $validator = [
            'page' => RespectValidator::optional(RespectValidator::intVal()->positive()->min(1)),
            'size' => RespectValidator::optional(RespectValidator::intVal()->positive()->min(1))
        ];

        return new Validation($validator);
    }

    public static function dataFormatErrorHandler(Request $request, Response $response, callable $next) {
        if ($request->getAttribute('has_errors')) {
            return JSON::errorResponse($response, 400, "Incorrect format in parameters.");
        } else {
            return $next($request, $response);
        }
    }
}