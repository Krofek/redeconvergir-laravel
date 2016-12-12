<?php

namespace App\Http\Controllers\Api;

use App\Repositories\InitiativeRepository as Initiative;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InitiativeController extends Controller
{
    protected $initiative;

    public function __construct(Initiative $initiative)
    {
        $this->initiative = $initiative;
    }

    public function index(Request $request)
    {
        
        /**
         * Apply boundaries given in form array('south' => ..., 'west' => ..., ...)
         */
        $boundaries = json_decode($request->input('boundaries'));
        $initiatives = $this->initiative->withinBoundary($boundaries);
        return \Response::json($initiatives);
    }
}
