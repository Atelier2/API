<?php
namespace GeoQuizz\Mobile\control;

use GeoQuizz\Mobile\commons\writers\JSON;
use GeoQuizz\Mobile\model\Picture;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Uuid;

class PictureController {
    protected $container;

    public function __construct(\Slim\Container $container = null) {
        $this->container = $container;
    }

    /**
     * @api {post} http://51.91.8.97:18380/users/:id/pictures/ Ajouter
     * @apiGroup Pictures
     *
     * @apiDescription Ajoute une image à la bibliothèque du User.
     *
     * @apiParam {String} description La description de l'image.
     * @apiParam {Number} latitude La latitude de l'image.
     * @apiParam {Number} longitude La longitude de l'image.
     * @apiParam {String} link Le lien où est hébergée l'image.
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "description": "Place Stanislas",
     *       "latitude": 38,
     *       "longitude": 53,
     *       "link": "https://www.imageshoster.com/image_1"
     *     }
     *
     * @apiHeader {String} Authorization Le token du User.
     *
     * @apiHeaderExample {json} Bearer Token:
     *     {
     *       "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA"
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 201 CREATED
     *     {
     *       "type": "resources",
     *       "picture": {
     *         "id": "18d0bca6-756a-4edb-94de-e7a764f562cc",
     *         "description": "Place Stanislas",
     *         "latitude": 38,
     *         "longitude": 53,
     *         "link": "https://www.imageshoster.com/image_1",
     *         "created_at": "2020-03-20 00:25:29",
     *         "updated_at": "2020-03-20 00:25:29",
     *         "id_user": "18d0eca6-756a-4e3b-9dde-e7a664f562cc"
     *       },
     *     }
     *
     * @apiError UserNotFound Le UUID ne correspond à aucun User.
     * @apiError InvalidToken Le Token du User est invalide, il doit se reconnecter.
     *
     * @apiErrorExample UserNotFound-Response:
     *     HTTP/1.1 404 NOT FOUND
     *     {
     *       "type": "error",
     *       "error": 404,
     *       "message": "User with ID db0913fa-934b-4981-9280-dc3bed19adb3 doesn't exist."
     *     }
     * @apiErrorExample InvalidToken-Response:
     *     HTTP/1.1 401 UNAUTHORIZED
     *     {
     *       "type": "error",
     *       "error": 401,
     *       "message": "Token expired."
     *     }
     */
    public function addPicture(Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $user = $request->getAttribute('user');

        try {
            $picture = new Picture();
            $picture->id = Uuid::uuid4();
            $picture->description = $body['description'];
            $picture->latitude = $body['latitude'];
            $picture->longitude = $body['longitude'];
            $picture->link = $body['link'];
            $picture->id_user = $user->id;
            $picture->saveOrFail();

            return JSON::successResponse($response, 201, [
                "type" => "resource",
                "picture" => $picture
            ]);
        } catch (\Throwable $exception) {
            return JSON::errorResponse($response, 500, "The series creation failed.");
        }
    }

    /**
     * @api {post} http://51.91.8.97:18380/users/:id_user/pictures/:id_picture/series/ Ajouter à une Series
     * @apiGroup Pictures
     *
     * @apiDescription Ajoute une image existance à des Series du User.
     *
     * @apiParam {Array} series Les UUID des Series auxquelles ajouter l'image.
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "series": [
     *         "cbcf5404-749f-4b55-86e9-e075bc2d94d5",
     *         "8744caf9-afec-4bf6-a5f2-e03045ddc8e5",
     *         "d9e73a08-9d7e-48a0-bed8-649e8eb73fd1"
     *       ]
     *     }
     *
     * @apiHeader {String} Authorization Le token du User.
     *
     * @apiHeaderExample {json} Bearer Token:
     *     {
     *       "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJhcGlfcGxheWVyIiwic3ViIjoiZ2FtZSIsImF1ZCI6InBsYXllciIsImlhdCI6MTU4NDc0NTQ0NywiZXhwIjoxNTg0NzU2MjQ3fQ.vkaSPuOdb95IHWRFda9RGszEflYh8CGxhaKVHS3vredJSl2WyqqNTg_VUbfkx60A3cdClmcBqmyQdJnV3-l1xA"
     *     }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 201 CREATED
     *     {
     *       "type": "resources",
     *       "picture": {
     *         "id": "18d0bca6-756a-4edb-94de-e7a764f562cc",
     *         "description": "Place Stanislas",
     *         "latitude": 38,
     *         "longitude": 53,
     *         "link": "https://www.imageshoster.com/image_1",
     *         "created_at": "2020-03-20 00:25:29",
     *         "updated_at": "2020-03-20 00:25:29",
     *         "id_user": "18d0eca6-756a-4e3b-9dde-e7a664f562cc"
     *       },
     *       "series": [
     *         "cbcf5404-749f-4b55-86e9-e075bc2d94d5",
     *         "8744caf9-afec-4bf6-a5f2-e03045ddc8e5",
     *         "d9e73a08-9d7e-48a0-bed8-649e8eb73fd1"
     *       ]
     *     }
     *
     * @apiError UserNotFound Le UUID ne correspond à aucun User.
     * @apiError PictureDoesNotBelongToUser La Series n'appartient pas au User.
     * @apiError InvalidToken Le Token du User est invalide, il doit se reconnecter.
     *
     * @apiErrorExample UserNotFound-Response:
     *     HTTP/1.1 404 NOT FOUND
     *     {
     *       "type": "error",
     *       "error": 404,
     *       "message": "User with ID db0913fa-934b-4981-9280-dc3bed19adb3 doesn't exist."
     *     }
     * @apiErrorExample PictureDoesNotBelongToUser-Response:
     *     HTTP/1.1 401 UNAUTHORIZED
     *     {
     *       "type": "error",
     *       "error": 401,
     *       "message": "This picture doesn't belong to this user."
     *     }
     * @apiErrorExample InvalidToken-Response:
     *     HTTP/1.1 401 UNAUTHORIZED
     *     {
     *       "type": "error",
     *       "error": 401,
     *       "message": "Token expired."
     *     }
     */
    public function addPictureToSeries(Request $request, Response $response, $args) {
        $picture = $request->getAttribute('picture');
        $user = $request->getAttribute('user');
        $series = $request->getAttribute('series');

        try {
            if ($picture->id_user === $user->id) {
                $picture->series()->attach($series);

                return JSON::successResponse($response, 201, [
                    "type" => "resource",
                    "picture" => $picture,
                    "series" => $series
                ]);
            } else {
                return JSON::errorResponse($response, 401, "This picture doesn't belong to this user.");
            }
        } catch (\Throwable $exception) {
            return JSON::errorResponse($response, 500, "Adding the picture to the series failed.".$exception->getMessage());
        }
    }
}