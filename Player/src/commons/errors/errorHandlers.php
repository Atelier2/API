<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GeoQuizz\Player\commons\Writers\Writer;

return [
    'notFoundHandler' => function ($container) {
        return function (Request $request, Response $response) use ($container){
            $response = Writer::jsonResponse($response, 400, [
                "type" => "error",
                "error" => 400,
                "message" => "Error in request format."
            ]);

            return $response;
        };
    },
    'notAllowedHandler' => function ($container) {
        return function (Request $request, Response $response, $allowed_methods) use ($container){
            $response = Writer::jsonResponse($response, 405, [
                "type" => "error",
                "error" => 405,
                "message" => "Unauthorized method. Allowed methods: ".implode(', ', $allowed_methods)
            ]);

            return $response;
        };
    },
    'phpErrorHandler' => function ($container) {
        return function (Request $request, Response $response, \Error $exception) use ($container){
            $response = Writer::jsonResponse($response, 500, [
                "type" => "error",
                "error" => 500,
                "message" => "Internal Server Error. Error : ".$exception->getMessage()." in the file: ".$exception->getFile()." at line: ".$exception->getLine()
            ]);

            return $response;
        };
    }
];