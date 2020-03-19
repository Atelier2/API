<?php
namespace GeoQuizz\Player\commons\middlewares;

use GeoQuizz\Player\commons\Writers\Writer;
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
        $authHeader = $request->getHeader("Authorization")[0];

        if (!empty($authHeader) and strpos($authHeader, "Bearer") !== false) {
            try {
                $tokenstring = sscanf($authHeader, "Bearer %s")[0];
                $token = FirebaseJWT::decode($tokenstring, $this->container->settings['JWT_secret'], ['HS512']);
                $request = $request->withAttribute("token", $token);

                return $next($request, $response);
            } catch (ExpiredException $e) {
                return Writer::jsonResponse($response, 401, [
                    "type" => "error",
                    "error" => 401,
                    "message" => "Token expired."
                ]);
            } catch (SignatureInvalidException $e) {
                return Writer::jsonResponse($response, 401, [
                    "type" => "error",
                    "error" => 401,
                    "message" => "Invalid signature."
                ]);
            } catch (BeforeValidException $e) {
                return Writer::jsonResponse($response, 401, [
                    "type" => "error",
                    "error" => 401,
                    "message" => "Token not valid yet."
                ]);
            } catch (\UnexpectedValueException $e) {
                return Writer::jsonResponse($response, 401, [
                    "type" => "error",
                    "error" => 401,
                    "message" => "Unexpected value in the token."
                ]);
            }
        } else {
            return Writer::jsonResponse($response, 401, [
                'type' => 'error',
                'error' => 401,
                'message' => "No token was provided in Authorization or it's not formatted correctly. Format: Bearer <token>"
            ]);
        }
    }
}