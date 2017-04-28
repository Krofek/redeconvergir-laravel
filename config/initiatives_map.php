<?php

return [
    'init' => [
        'center'     => ['lat' => 46.198654, 'lng' => 14.806461],
        'zoom'       => 9,
        'mapTypeId'  => 'terrain',
        'options'    => [
            'map' => [
                'scrollwheel'      => true,
                'minZoom'          => 7,
                'disableDefaultUI' => true, // a way to quickly hide all controls
                'mapTypeControl'   => false,
                'zoomControl'      => false,
            ],
            'infoWindow' => [
                'disableAutoPan' => true
            ]
        ],
        'marker'     => [
            'icon' => [
                'path'          => "M27.648-41.399q0-3.816-2.7-6.516t-6.516-2.7-6.516 2.7-2.7 6.516 2.7 6.516 6.516 2.7 6.516-2.7 2.7-6.516zm9.216 0q0 3.924-1.188 6.444l-13.104 27.864q-.576 1.188-1.71 1.872t-2.43.684-2.43-.684-1.674-1.872l-13.14-27.864q-1.188-2.52-1.188-6.444 0-7.632 5.4-13.032t13.032-5.4 13.032 5.4 5.4 13.032z",
                'scale'         => 0.7,
                'strokeWeight'  => 1,
                'strokeColor'   => '#fff',
                'strokeOpacity' => 0.7,
                'fillColor'     => '#444',
                'fillOpacity'   => 1
            ],
        ],
    ]
];