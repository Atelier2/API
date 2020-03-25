<?php
namespace GeoQuizz\Mobile\control;

use GeoQuizz\Mobile\commons\writers\JSON;
use GeoQuizz\Mobile\model\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Uuid;
use Firebase\JWT\JWT;

class UserController {
    protected $container;

    public function __construct(\Slim\Container $container = null) {
        $this->container = $container;
    }

    /**
     * @api {post} https://api.mobile.local.19343/users/signup/ Créer
     * @apiGroup Users
     *
     * @apiDescription Crée un User.
     *
     * @apiParam {String} firstname Le prénom du User.
     * @apiParam {String} lastname Le nom de famille du User.
     * @apiParam {String} email L'addresse e-mail du User.
     * @apiParam {String} password Le mot de passe du User.
     * @apiParam {String} phone Le numéro de téléphone du User.
     * @apiParam {Number} street_number Le numéro de la rue du User.
     * @apiParam {String} street Le nom de la rue du User.
     * @apiParam {String} city Le nom de la ville du User.
     * @apiParam {String} zip_code Le code postal du User.
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "firstname": "Albert",
     *       "lastname": "Einstein",
     *       "email": "albert.einstein@physics.com",
     *       "password": "physics",
     *       "phone": "0612345678",
     *       "street_number": 2,
     *       "street": "Boulevard Charlemagne",
     *       "city": "Nancy",
     *       "zip_code": 54000
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 201 CREATED
     *     {
     *       "type": "resource",
     *       "user": {
     *         "id": "db0916fa-934b-4981-9980-d53bed190db3",
     *         "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA",
     *         "firstname": "Albert",
     *         "lastname": "Einstein",
     *         "email": "albert.einstein@physics.com",
     *         "phone": "0612345678",
     *         "street_number": 2,
     *         "street": "Boulevard Charlemagne",
     *         "city": "Nancy",
     *         "zip_code": 54000
     *         "created_at": "2020-03-24 13:05:51",
     *         "updated_at": "2020-03-24 13:05:51"
     *       }
     *     }
     *
     * @apiError EmailAlreadyTaken L'adresse e-mail est déjà utilisée.
     *
     * @apiErrorExample EmailAlreadyTaken-Response:
     *     HTTP/1.1 401 UNAUTHORIZED
     *     {
     *       "type": "error",
     *       "error": 401,
     *       "message": "This e-mail address is already taken."
     *     }
     */
    public function signUp(Request $request, Response $response, $args) {
        $body = $request->getParsedBody();

        try {
            $existingUser = User::query()->where('email', '=', $body['email'])->first();
            if (isset($existingUser)) {
                return JSON::errorResponse($response, 401, "This e-mail address is already taken.");
            }

            $user = new User();
            $user->id = Uuid::uuid4();
            $user->token = JWT::encode([
                "aud" => $user->id,
                "iat" => time(), // Current timestamp
                "exp" => time() + (3 * 60 * 60), // Current timestamp + 3 hours
            ], $this->container->settings['JWT_secret'], "HS512");
            $user->firstname = $body['firstname'];
            $user->lastname = $body['lastname'];
            $user->email = $body['email'];
            $user->password = password_hash($body['password'], PASSWORD_DEFAULT);
            $user->phone = isset($body['phone']) ? $body['phone'] : null;
            $user->street_number = $body['street_number'];
            $user->street = $body['street'];
            $user->city = $body['city'];
            $user->zip_code = $body['zip_code'];
            $user->saveOrFail();

            unset($user->password);

            return JSON::successResponse($response, 201, [
                "type" => "resource",
                "user" => $user
            ]);
        } catch (\Throwable $exception) {
            return JSON::errorResponse($response, 500, "Your account creation failed.");
        }
    }

    /**
     * @api {post} https://api.mobile.local.19343/users/signin/ Connecter
     * @apiGroup Users
     *
     * @apiDescription Connecte un User.
     *
     * @apiHeader {String} Authorization L'adresse e-mail et le mot de passe en Basic Auth.
     *
     * @apiHeaderExample {json} Basic Auth:
     *     {
     *       "Authorization": "Basic QWxhZGRpbjpPcGVuU2VzYW1l"
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "type": "resource",
     *       "user": {
     *         "id": "db0916fa-934b-4981-9980-d53bed190db3",
     *         "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA",
     *         "firstname": "Albert",
     *         "lastname": "Einstein",
     *         "email": "albert.einstein@physics.com",
     *         "phone": "0612345678",
     *         "street_number": 2,
     *         "street": "Boulevard Charlemagne",
     *         "city": "Nancy",
     *         "zip_code": 54000
     *         "created_at": "2020-03-24 13:05:51",
     *         "updated_at": "2020-03-24 13:06:51"
     *       }
     *     }
     *
     * @apiError InvalidCredentials L'adresse e-mail ou le mot de passe sont incorrects.
     *
     * @apiErrorExample InvalidCredentials-Response:
     *     HTTP/1.1 401 UNAUTHORIZED
     *     {
     *       "type": "error",
     *       "error": 401,
     *       "message": "Email or password are incorrect."
     *     }
     */
    public function signIn(Request $request, Response $response, $args) {
        $email = $request->getAttribute('email');
        $password = $request->getAttribute('password');

        try {
            $user = User::query()->where('email', '=', $email)->firstOrFail();

            if (password_verify($password, $user->password)) {
                $user->token = JWT::encode([
                    "aud" => $user->id,
                    "iat" => time(), // Current timestamp
                    "exp" => time() + (3 * 60 * 60), // Current timestamp + 3 hours
                ], $this->container->settings['JWT_secret'], "HS512");
                $user->saveOrFail();

                unset($user->password);

                return JSON::successResponse($response, 200, [
                    "type" => "resource",
                    "user" => $user
                ]);
            } else {
                return JSON::errorResponse($response, 401, "Email or password are incorrect.");
            }
        } catch (ModelNotFoundException $exception) {
            return JSON::errorResponse($response, 401, "Email or password are incorrect.");
        } catch (\Throwable $exception) {
            return JSON::errorResponse($response, 500, "The user update failed.");
        }
    }
}