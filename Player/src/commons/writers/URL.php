<?php
namespace GeoQuizz\Player\commons\writers;

use Psr\Http\Message\ServerRequestInterface as Request;

class URL {
    public static function getRequestEndpoint(Request $request) {
        $scheme = $request->getUri()->getScheme();
        $host = $request->getUri()->getHost();
        $port = $request->getUri()->getPort();
        $path = $request->getUri()->getPath();
        $fullEndpoint = "$scheme://$host:$port$path";

        if ($fullEndpoint{strlen($fullEndpoint) - 1} === "/") {
            $fullEndpoint = substr($fullEndpoint, 0, -1);
        }

        return $fullEndpoint;
    }
}