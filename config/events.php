<?php

return [
    'input' => [
        'name'        => 'required',
        'start_at'    => 'required|date',
        'end_at'      => 'required|date|after:start_at',
        'website'     => 'required|url',
        'description' => 'required|min:20',
        'locations'   => 'required|json', #this will become array of json strings in future
        'initiatives' => 'required|array',
    ]
];