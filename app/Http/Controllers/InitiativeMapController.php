<?php

namespace App\Http\Controllers;

use App\Repositories\InitiativeRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

class InitiativeMapController extends Controller
{
    protected $initiative;

    public function __construct(InitiativeRepository $initiativeRepository)
    {
        $this->initiative = $initiativeRepository;
    }

    public function index(Request $request)
    {
        $init = config('initiatives_map.init');
        $initiatives = $this->initiative->getAll();

        return view('initiatives', [
            'init'        => json_encode($init),
            'initiatives' => json_encode($initiatives)
        ]);
    }
}
