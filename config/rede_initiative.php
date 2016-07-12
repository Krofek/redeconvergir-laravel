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
        'name'           => 'required|unique:initiatives',
        'url'            => 'url',
        'video_url'      => 'url',
        'logo_url'       => 'url',
        'logo'           => 'image',
        'doc_url'        => 'url',
        'doc'            => '',
        'description'    => 'required|min:120',
        'start_at'       => 'required',
        'audience_size'  => 'required|in:0,1,2,3,4,5,6',
        'group_size'     => 'required|numeric',
        'area_size'      => 'required|numeric',
        'accepts_visits' => 'required|in:0,1,2',
        'location_type'  => 'required|in:0,1,2',
        'status'         => 'required|in:0,1,2,3',
        'promoter'       => '',

        'category_id'    => 'required|exists:initiative_categories,id',
        'category_other' => 'required_if:category_id,0',
        'contact'        => 'required|array',
        'location'       => 'required|array',
        'tags'           => 'array',
        'audience'       => 'array'
    ],

    'input_contact' => [
        'street'      => 'required',
        'city'        => 'required',
        'postal_code' => 'required',
        'name'        => 'required',
        'email'       => 'required|email',
        'phone'       => '',
        'other'       => ''
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

    'audience' => [
        0 => 'other',
        1 => 'children',
        2 => 'teens',
        3 => 'adults',
        4 => 'elderly',
        5 => 'families',
        6 => 'handicapped',
        7 => 'children_with_special_needs',
        8 => 'general'
    ],

    'accepts_visits' => [
        0 => 'yes',
        1 => 'no',
        2 => 'confirmation_required'
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
];