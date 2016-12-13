<?php

namespace App\Http\Controllers\Api;

use App\Repositories\InitiativeRepository;
use App\Repositories\LocationRepository;
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
        $markers = $this->location->mapMarkers(); #pass filters here
        return \Response::json([
            'markers'     => $markers
        ]);
    }

    public function listItems(Request $request)
    {
        $initiatives = $this->initiative->mapListItems();
        return \Response::json([
            'initiatives' => $initiatives,
        ]);
    }
}
