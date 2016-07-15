<?php
/**
 * Created by PhpStorm.
 * User: krofek
 * Date: 7/13/16
 * Time: 4:22 PM
 */

$factory->define(App\Models\Initiative\Tag::class, function (Faker\Generator $faker) {

});

$factory->define(App\Models\Initiative\Audience::class, function (Faker\Generator $faker) {

});

$factory->define(App\Models\Initiative\Tag\Other::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name
    ];
});

$factory->define(App\Models\Initiative\Audience\Other::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name
    ];
});

$factory->define(App\Models\Initiative::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->userName,
        'url'            => $faker->url,
        'video_url'      => $faker->url,
        'logo_url'       => $faker->imageUrl(200, 200),
        'doc_url'        => $faker->url,
        'description'    => $faker->words(30, true),
        'start_at'       => $faker->dateTime,
        'audience_size'  => random_int(0, 6),
        'group_size'     => random_int(0, 1000),
        'area_size'      => random_int(0, 1000),
        'accepts_visits' => random_int(0, 2),
        'location_type'  => random_int(0, 2),
        'status'         => random_int(0, 3),
        'promoter'       => $faker->name,
        'contact_id'     => function () {
            return factory(App\Models\Contact::class)->create()->id;
        },
        'location_id'    => function () {
            return factory(App\Models\Location::class)->create()->id;
        }
    ];
});