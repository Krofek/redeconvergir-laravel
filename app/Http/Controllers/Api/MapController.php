<?php

namespace App\Http\Controllers\Api;

use App\Engines\ElasticsearchEngine;
use App\Models\Initiative;
use App\Models\Initiative\Audience;
use App\Models\Initiative\Category;
use App\Repositories\InitiativeRepository;
use App\Repositories\LocationRepository;
use App\Services\InitiativeService;
use App\Services\MapService;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MapController extends Controller
{
    protected $initiative;
    protected $location;

    public function __construct(InitiativeRepository $initiative, LocationRepository $location)
    {
        $this->initiative = $initiative;
        $this->location = $location;
    }

    public function filtersData(Request $request)
    {
        $filtersData = [];
        $filtersData['categories'] = Category::all()->map(function(Category $category) {
            $collection = collect($category);
            return $collection->only(['id', 'name', 'description']);
        });
        $filtersData['audiences'] = Audience::all()->map(function(Audience $audience) {
            $collection = collect($audience);
            return $collection->only(['id', 'name']);
        });

        return \Response::json([
            'filters_data' => $filtersData,
        ]);
    }

    public function markers(Request $request)
    {
        $filters = $request->input('filters');
        $markers = $this->location->mapMarkers($filters);
        return \Response::json([
            'markers' => $markers
        ]);
    }

    public function initiatives(Request $request)
    {
        $query = ElasticsearchEngine::prepareSearchQuery($request->input('searchQuery'));
        $boundary = json_decode($request->input('boundaries'));
        $filters = $request->input('filters');

        $result = Initiative::search([
            "query_string" => [
                'fields'           => ['name^3', 'short_description^2', 'description', 'keywords^2'],
                'query'            => $query,
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

        ], function (Initiative $initiative) use ($boundary, $filters) {
            return $initiative->with([
                'categories' => function ($query) use ($filters) {
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
            ])->whereHas('categories', function($query) use ($filters) {
                MapService::applyFilters($query, $filters);
            });
        })->orderBy('_score', 'desc')->orderBy('name.keyword', 'asc')->get();

        $initiatives = InitiativeService::prepareForApi($result);

        return \Response::json([
            'initiatives' => $initiatives,
        ]);
    }
}
