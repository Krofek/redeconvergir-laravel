<?php

namespace App\Http\Controllers\Api;

use App\Engines\ElasticsearchEngine;
use App\Models\Initiative;
use App\Repositories\InitiativeRepository;
use App\Repositories\LocationRepository;
use App\Services\InitiativeService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InitiativeController extends Controller
{
    protected $initiative;
    protected $location;

    public function __construct(InitiativeRepository $initiative, LocationRepository $location)
    {
        $this->initiative = $initiative;
        $this->location = $location;
    }

//    /**
//     * Apply boundaries given in form array('south' => ..., 'west' => ..., ...)
//     */
//    $boundaries = json_decode($request->input('boundaries'));
//    $initiatives = $this->initiative->withinBoundary($boundaries);

    public function markers(Request $request)
    {
        $boundary = json_decode($request->input('boundaries'));
        $markers = $this->location->mapMarkers(null); #pass filters here
        return \Response::json([
            'markers' => $markers
        ]);
    }

    public function initiatives(Request $request)
    {
        $search = trim(mb_strtolower(ElasticsearchEngine::escape($request->input('searchQuery'))));
        if($search === "") {
            $search = "*";
        }
        $boundary = json_decode($request->input('boundaries'));

        $result = Initiative::search([
            "query_string" => [
                'fields'           => ['name^3', 'short_description^2', 'description', 'keywords^2'],
                'query'            => $search,
                'use_dis_max'      => true,
                'default_operator' => 'AND'
            ],
//        "bool" => [
//            "must" => [
//                "multi_match" => [
//                    'fields' => ['name^3', 'short_description^2', 'description', 'keywords^2'],
//                    'type' => 'phrase_prefix',
//                    'query' => $search,
//                    'zero_terms_query' => 'all'
//                ],
//            ],
//            "filter" => [
//                "nested" => [
//                    "path" => "locations",
//                    "query" => [
//                        "constant_score" => [
//                            "filter" => [
//                                "geo_bounding_box" => [
//                                    "locations.position" => [
//                                        "top" => $boundary->north,
//                                        "left" => -180,
//                                        "bottom" => -90,
//                                        "right" => 180,
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
//                ],
//            ],
//        ],

        ], function (Initiative $initiative) use ($boundary) {
            return $initiative->with([
                'categories' => function ($query) {
                    $query->select('id', 'name', 'description');
                },
                'locations'  => function ($query) use ($boundary) {
                    $query->select('id', 'lat', 'lng')
                        ->selectRaw('(CASE WHEN (lat BETWEEN ? AND ?) AND (lng BETWEEN ? AND ?) THEN 1 ELSE 0 END) AS within_boundary', [
                            'latSouth' => $boundary->south,
                            'latNorth' => $boundary->north,
                            'lngWest'  => $boundary->west,
                            'lngEast'  => $boundary->east
                        ]);
                }
            ]);
        })->orderBy('_score', 'desc')->orderBy('name.keyword', 'asc')->get();

        $initiatives = InitiativeService::prepareForApi($result);

        return \Response::json([
            'initiatives' => $initiatives,
        ]);
    }
}
