<?php
namespace GeoQuizz\Mobile\commons\middlewares;

use GeoQuizz\Mobile\commons\writers\JSON;
use Respect\Validation\Validator as RespectValidator;
use DavidePastore\Slim\Validation\Validation;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Validator {
    const ACCENTS = "À à Â â Ä ä Ç ç É é È è Ê ê Ë ë Î î Ï ï Ô ô Ö ö Ù ù Û û Ü ü";
    const PONCTUATION = ". ; : ! ? , - _ \" / ' ( ) [ ] { } + = % * $ € £ & # @";

    public static function createUserValidator() {
        $validator = [
            'firstname' => RespectValidator::alpha(self::ACCENTS),
            'lastname' => RespectValidator::alpha(self::ACCENTS),
            'email' => RespectValidator::email(),
            'password' => RespectValidator::notOptional(),
            'phone' => RespectValidator::optional(RespectValidator::phone()),
            'street_number' => RespectValidator::intVal()->positive()->min(1),
            'street' => RespectValidator::alnum(),
            'city' => RespectValidator::alpha(),
            'zip_code' => RespectValidator::alnum()
        ];

        return new Validation($validator);
    }

    public static function createSeriesValidator() {
        $validator = [
            'city' => RespectValidator::alpha(self::ACCENTS." -"),
            'distance' => RespectValidator::intVal(),
            'latitude' => RespectValidator::floatVal()->positive(),
            'longitude' => RespectValidator::floatVal()->positive(),
            'zoom' => RespectValidator::intVal()->positive()->min(1),
            'nb_pictures' => RespectValidator::intVal()->positive()->min(1)
        ];

        return new Validation($validator);
    }

    public static function addPictureValidator() {
        $validator = [
            'description' => RespectValidator::alnum(self::ACCENTS." ".self::PONCTUATION),
            'latitude' => RespectValidator::floatVal()->positive(),
            'longitude' => RespectValidator::floatVal()->positive(),
            'link' => RespectValidator::url()
        ];

        return new Validation($validator);
    }

    public static function addPictureToSeriesValidator() {
        $validator = [
            'series' => RespectValidator::arrayVal()->each(RespectValidator::alnum('-'))
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