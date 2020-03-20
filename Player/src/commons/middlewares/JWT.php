<?php
namespace GeoQuizz\Player\commons\middlewares;

use GeoQuizz\Player\commons\writers\JSON;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;

class JWT {
    protected $container;

    public function __construct(\Slim\Container $container = null) {
        $this->container = $container;
    }

    public function checkJWT(Request $request, Response $response, callable $next) {
        $authHeader = !empty($request->getHeader("Authorization")) ? $request->getHeader("Authorization")[0] : null;

        if (!empty($authHeader) and strpos($authHeader, "Bearer") !== false) {
            try {
                $tokenstring = sscanf($authHeader, "Bearer %s")[0];
                FirebaseJWT::decode($tokenstring, $this->container->settings['JWT_secret'], ['HS512']);

                return $next($request, $response);

            } catch (ExpiredException $e) {
                return JSON::errorResponse($response, 401, "Token expired.");

            } catch (SignatureInvalidException $e) {
                return JSON::errorResponse($response, 401, "Invalid signature.");

            } catch (BeforeValidException $e) {
                return JSON::errorResponse($response, 401, "Token not valid yet.");

            } catch (\UnexpectedValueException $e) {
                return JSON::errorResponse($response, 401, "Unexpected value in the token.");

            }
        } else {
            return JSON::errorResponse($response, 401, "No token was provided in Authorization or it's not formatted correctly. Format: Bearer <token>");
        }
    }
}