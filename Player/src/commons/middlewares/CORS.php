<?php
namespace GeoQuizz\Player\commons\middlewares;

use GeoQuizz\Player\commons\Writers\Writer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CORS {
    public function addCORSHeaders(Request $request, Response $response, callable $next) {
        if (!empty($request->getHeader('Origin'))) {
            return $next($request, $response)
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', '*')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        } else {
            return Writer::jsonResponse($response, 401, [
                'type' => 'error',
                'error' => 401,
                'message' => 'Origin header is missing.'
            ]);
        }
    }
}