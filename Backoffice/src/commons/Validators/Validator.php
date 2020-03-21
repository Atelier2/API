<?php

namespace GeoQuizz\Backoffice\commons\Validators;

use \Respect\Validation\Validator as v;

class Validator
{
    public static function validatorsUsers()
    {
        return
            [
                'firstname' => v::StringType()->notEmpty()->alpha(),
                'lastname' => v::StringType()->notEmpty()->alpha(),
                'email' => v::email()->notEmpty(),
                'phone' => v::phone()->notEmpty(),
                'street_number' => v::intType()->notEmpty(),
                'street' => v::StringType()->notEmpty()->alpha(),
                'city' => v::stringType()->notEmpty()->alpha(),
                'zip_code' => v::intType()->notEmpty(),
            ];
    }

    public static function validatorsSeries()
    {
        return
            [
                'city' => v::StringType()->notEmpty()->alpha(),
                'distance' => v::intType()->notEmpty(),
                'latitude' => v::StringType()->notEmpty()->alpha(),
                'longitude' => v::StringType()->notEmpty()->alpha(),
                'zoom' => v::intType()->notEmpty(),
                'nb_pictures' => v::intVal()->notEmpty(),
            ];
    }

    public static function validatorsPicture()
    {
        return
            [
                'description' => v::StringType()->notEmpty()->alpha(),
                'latitude' => v::notEmpty(),
                'longitude' => v::notEmpty(),
                'link' => v::url()->notEmpty(),
            ];
    }
}
