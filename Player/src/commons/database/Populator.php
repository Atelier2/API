<?php
namespace GeoQuizz\Player\commons\database;

use Faker\Factory;
use GeoQuizz\Player\model\Series;
use Ramsey\Uuid\Uuid;

class Populator {
    public static function populateSeries() {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $serie = new Series();
            $serie->id = Uuid::uuid4();
            $serie->city = $faker->city;
            $serie->distance = random_int(100, 1000);
            $serie->latitude = $faker->latitude;
            $serie->longitude = $faker->longitude;
            $serie->zoom = random_int(8, 13);
            $serie->nb_pictures = 10;
            $serie->id_user = Uuid::uuid4();
        }
    }
}