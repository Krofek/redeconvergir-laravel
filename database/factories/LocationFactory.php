<?php
/**
 * Created by PhpStorm.
 * User: krofek
 * Date: 7/13/16
 * Time: 4:23 PM
 */

$factory->define(App\Models\Location::class, function(Faker\Generator $faker) {
    return [
        'lat' => $faker->latitude,
        'lng' => $faker->longitude
    ];
});