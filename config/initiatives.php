<?php
/**
 * Settings for the Initiative model
 *
 * - validation
 * - seeders
 * - etc.
 *
 *
 * User: krofek
 * Date: 7/10/16
 * Time: 4:04 PM
 */

return [
    'input' => [
        'name'             => 'bail|required|unique:initiatives,name',
        'start_at'         => 'required|date',
        'categories'       => 'required|array',
        'status'           => 'required|in:0,1,2,3',
        'group_size'       => 'numeric',
        'audience'         => 'required|array',
        'audience_other'   => 'string',
        'audience_size'    => 'required|in:0,1,2,3,4,5,6',
        'locations'        => 'required|json', #this will become array of json strings in future
        'location_type'    => 'required|in:0,1,2',
        'area_size'        => 'numeric',
        'logo_url'         => 'required|string',
        'cover_photo_url'  => 'required|string',
        'description'      => 'required|min:20',
        'contact.name'     => 'required',
        'contact.email'    => 'required|email',
        'contact.phone'    => '',
        'contact.website'  => 'required_without:contact.facebook',
        'contact.facebook' => 'required_without:contact.website',
    ],

    'input_location' => [
        'lat' => 'required',
        'lng' => 'required'
    ],

    'tags' => [
        0  => 'other',
        1  => 'agriculture',
        2  => 'livestock',
        3  => 'livestock_organic',
        4  => 'bio_engineering',
        5  => 'eco_technology',
        6  => 'art',
        7  => 'education',
        8  => 'health',
        9  => 'spiritual',
        10 => 'alternative_economy',
        11 => 'means_sharing',
        12 => 'social_endeavours'
    ],

    'location_type' => [
        0 => 'urban',
        1 => 'rural',
        2 => 'urban_and_rural'
    ],

    'audience_size' => [
        0 => '1 - 10',
        1 => '11 - 25',
        2 => '26 - 100',
        3 => '101 - 500',
        4 => '501 - 5000',
        5 => '5001 - 10000',
        6 => '10001+'
    ],

    'status' => [
        0 => 'germinating',
        1 => 'taking_root',
        2 => 'fruiting',
        3 => 'seeding'
    ],

    'images' => [
        'logo'        => ['size' => 150], # 150 x 150 px logo,
        'cover_photo' => ['width' => 851, 'height' => 315]
    ],

    'audience_other_id' => 1 # id of 'Other'
];