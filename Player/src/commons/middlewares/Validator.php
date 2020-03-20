<?php
namespace GeoQuizz\Player\commons\middlewares;

use GeoQuizz\Player\commons\writers\JSON;
use Respect\Validation\Validator as RespectValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Validator {
    public static function updateGameValidator() {
        return [
            'score' => RespectValidator::optional(RespectValidator::intVal()->positive()),
            'id_status' => RespectValidator::optional(RespectValidator::intVal()->positive()->between(0,2))
        ];
    }

    public static function createGameValidator() {
        return [
            'username' => RespectValidator::alnum(),
            'id_series' => RespectValidator::alnum('-')
        ];
    }

    public static function dataFormatErrorHandler(Request $request, Response $response, callable $next) {
        if ($request->getAttribute('has_errors')) {
            return JSON::errorResponse($response, 400, "Incorrect format in fields.");
        } else {
            return $next($request, $response);
        }
    }
}