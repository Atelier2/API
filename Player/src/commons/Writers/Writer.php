<?php
namespace GeoQuizz\Player\commons\Writers;

use Psr\Http\Message\ResponseInterface as Response;

class Writer {
    public static function jsonResponse(Response $response, $status, $json_array) {
        $response = $response->withStatus($status)
            ->withHeader("Content-Type", "application/json;charset=utf-8");

        $response->getBody()
            ->write(json_encode($json_array));

        return $response;
    }
}