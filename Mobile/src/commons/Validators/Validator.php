<?php

namespace GeoQuizz\Mobile\commons\Validators;

use \Respect\Validation\Validator as v;

class Validator
{
    public static function validatorsPictures()
    {
        return
            [
                'description' => v::StringType()->alpha(),
                'latitude' => v::notEmpty(),
                'longitude' => v::notEmpty(),
                'link' => v::url()->notEmpty()
            ];
    }

    public static function validatorsSeriesPictures()
    {
        return
            [
                'description' => v::StringType()->alpha(),
                'distance' => v::intType()->notEmpty(),
                'latitude' => v::notEmpty(),
                'longitude' => v::notEmpty(),
                'zoom' => v::intType()->notEmpty(),
                'nb_pictures' => v::intType()->notEmpty()
            ];
    }

    public static function validatorsUsers()
    {
        return
            [
                'firstname' => v::StringType()->alpha(),
                'lastname' => v::StringType()->notEmpty(),
                'email' => v::email(),
                'password' => v::alnum()->notEmpty(),
                'phone' => v::phone(),
                'street_number' => v::intType()->notEmpty(),
                'street' => v::StringType()->notEmpty(),
                'city' => v::StringType()->notEmpty(),
                'zip_code' => v::alnum()->notEmpty()
            ];
    }

    public static function validatorsGame()
    {
        return
            [
                'score' => v::intType()->alpha(),
                'pseudo' => v::StrinType()->notEmpty()
            ];
    }
}
