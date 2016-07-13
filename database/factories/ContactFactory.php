<?php
/**
 * Created by PhpStorm.
 * User: krofek
 * Date: 7/13/16
 * Time: 4:24 PM
 */

$factory->define(App\Models\Contact::class, function(Faker\Generator $faker) {
    return [
        'street'      => $faker->streetName,
        'city'        => $faker->city,
        'postal_code' => $faker->postcode,
        'name'        => $faker->name,
        'email'       => $faker->email,
        'phone'       => $faker->phoneNumber,
        'other'       => ''
    ];
});