<?php

namespace App\Http\Controllers;

use App\Models\Initiative;
use App\Repositories\InitiativeRepository;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

use App\Http\Requests;

class InitiativeMapController extends Controller
{
    protected $initiative;

    /**
     * InitiativeMapController constructor.
     * @param InitiativeRepository $initiativeRepository
     */
    public function __construct(InitiativeRepository $initiativeRepository)
    {
        $this->initiative = $initiativeRepository;
    }

    public function index(Request $request)
    {
        $init = config('initiatives_map.init');
        return view('initiatives', [
            'init' => json_encode($init),
        ]);
    }
}
