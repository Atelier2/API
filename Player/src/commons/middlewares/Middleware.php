<?php
namespace GeoQuizz\Player\commons\middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GeoQuizz\Player\commons\Writers\Writer;

class Middleware {
    public function checkAuthorization(Request $request, Response $response, callable $next) {
        if (!empty($getHeader = $request->getHeader("Authorization")[0]) and strpos($getHeader, "Basic") !== false) {
            $request = $request->withAttribute("getHeader", $getHeader);
            return $next($request, $response);
        } else {
            return Writer::jsonResponse($response, 401, [
                'type' => 'error',
                'error' => 401,
                'message :' => 'No data was found in Basic Authorization.'
            ]);
        }
    }

    public function decodeAuthorization(Request $request, Response $response, callable $next) {
        $getHeader = $request->getAttribute("getHeader");
        $getHeader_value = substr($getHeader, 6);
        $getHeader_value_decode = base64_decode($getHeader_value);
        $dote_position = strpos($getHeader_value_decode, ':');
        $user_name = substr($getHeader_value_decode, 0, $dote_position);
        $user_passwd = substr($getHeader_value_decode, $dote_position + 1);
        $request = $request->withAttribute("user_name", $user_name);
        $request = $request->withAttribute("user_passwd", $user_passwd);
        return $next($request, $response);
    }


    public function checkToken(Request $request, Response $response, callable $next) {
        if (!empty($request->getQueryParams('token', null))) {
            $token = $request->getQueryParams("token");
            $request = $request->withAttribute("token", $token);
            return $next($request, $response);
        } else {
            $response = $response->withStatus(401)
                ->withHeader('Content-Type', 'application/json;charset=utf-8');
            $response->getBody()->write(json_encode(['type' => 'error', 'Error_code' => 401, 'message :' => 'no token found in URL']));


            return Writer::jsonResponse($response, 401, [
                'type' => 'error',
                'error' => 401,
                'message :' => 'no token found in URL']);
        }
    }

    public function getToken(Request $request, Response $response, callable $next) {
        $token = $request->getAttribute("token");
        $token = $token["token"];
        $request = $request->withAttribute("token", $token);
        return $next($request, $response);
    }
}