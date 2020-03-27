<?php

namespace GeoQuizz\Backoffice\commons\Validators;

use \Respect\Validation\Validator as v;

class Validator
{
    const ACCENTS = "À à Â â Ä ä Ç ç É é È è Ê ê Ë ë Î î Ï ï Ô ô Ö ö Ù ù Û û Ü ü";

    const PONCTUATION = ". ; : ! ? , - _ \" / ' ( ) [ ] { } + = % * $ € £ < > & # @";

    public static function validatorsUsers()
    {
        return
            [
                'firstname' => v::alnum(self::ACCENTS . " " . self::PONCTUATION),
                'lastname' => v::alnum(self::ACCENTS . " " . self::PONCTUATION),
                'email' => v::email()->notEmpty(),
                'phone' => v::phone()->notEmpty(),
                'password' => v::notEmpty(),
                'street_number' => v::intType()->notEmpty(),
                'street' => v::alnum(self::ACCENTS . " " . self::PONCTUATION),
                'city' => v::alnum(self::ACCENTS . " " . self::PONCTUATION),
                'zip_code' => v::intType()->notEmpty(),
            ];
    }

    public static function validatorsSeries()
    {
        return
            [
                'city' => v::alpha(self::ACCENTS . " -"),
                'distance' => v::intType()->notEmpty(),
                'latitude' => v::floatType()->notEmpty(),
                'longitude' => v::floatType()->notEmpty(),
                'zoom' => v::intType()->notEmpty(),
                'nb_pictures' => v::numeric(),
            ];
    }

    public static function validatorsPicture()
    {
        return
            [
                'description' => v::alnum(self::ACCENTS . " " . self::PONCTUATION),
                'latitude' => v::floatType()->notEmpty(),
                'longitude' => v::floatType()->notEmpty(),
                'link' => v::url()->notEmpty(),
            ];
    }

    public static function validatorSeriesPictures()
    {
        return
            [
                "pictures" => v::arrayVal()->each(v::arrayVal()
                    ->key('id', v::stringType()->notEmpty()))
            ];
    }

}
