<?php
/**
 * Created by PhpStorm.
 * User: krofek
 * Date: 7/13/16
 * Time: 4:23 PM
 */

$factory->define(App\Models\Initiative\Category\Other::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Models\Initiative\Category::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->words(5, true)
    ];
});