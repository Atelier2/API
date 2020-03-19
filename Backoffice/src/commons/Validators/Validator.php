<?php

namespace GeoQuizz\Backoffice\commons\Validators;

use \Respect\Validation\Validator as v;

class Validator
{
    public static function validators()
    {
        return
            [
                'firstname' => v::StringType()->alpha(),
                'lastname' => v::StringType()->alpha(),
                'email' => v::email(),
                'phone' => v::phone(),
                'street_number' => v::intVal(),
                'street' => v::StringType()->alpha(),
                'city' => v::stringType()->alpha(),
                'zip_code' => v::intVal(),
            ];
    }
}
