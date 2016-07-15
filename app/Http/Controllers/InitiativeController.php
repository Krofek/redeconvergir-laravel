<?php

namespace App\Http\Controllers;

use App\Http\Requests\Initiative\StoreRequest;
use App\Interfaces\InitiativeRepositoryInterface;
use App\Models\Initiative;
use App\Services\InitiativeService;
use Illuminate\Http\Request;

use App\Http\Requests;

class InitiativeController extends Controller
{
    public static $parameters = [
        'name'           => 'test',
        'url'            => '',
        'video_url'      => '',
        'logo_url'       => 'http://placehold.it/50x50',
        'doc_url'        => 'http://nonexistent.com',
        'description'    => 'You think water moves fast? You should see ice. It moves like it has a mind. Like it knows it killed the world once and got a taste for murder. After the avalanche, it took us a week to climb out. Now, I don\'t know exactly when we turned on each other, but I know that seven of us survived the slide... and only five made it out. Now we took an oath, that I\'m breaking now. We said we\'d say it was the snow that killed the other two, but it wasn\'t. Nature is lethal but it doesn\'t hold a candle to man.',
        'start_at'       => '2016-12-12',
        'audience_size'  => 4,
        'group_size'     => 50,
        'area_size'      => 120,
        'accepts_visits' => 1,
        'location_type'  => 0,
        'status'         => 1,
        'promoter'       => '',

        'contact'  => [
            'street'      => 'Test',
            'city'        => 'Test',
            'postal_code' => '1000',
            'name'        => 'test contact',
            'email'       => 'test@tester.com',
            'phone'       => '',
            'other'       => ''
        ],
        'location' => [
            'lat' => 31.45599299,
            'lng' => 41.49014819
        ],
        'tags'     => [0, 1, 2],
        'tags_other' => 'testing_tag',
        'audience' => [0, 1, 2],
        'audience_other' => 'testing_audience'
    ];

    /**
     * @var InitiativeRepositoryInterface
     */
    protected $initiative;

    /**
     * @var InitiativeService
     */
    protected $service;

    public function __construct(InitiativeRepositoryInterface $initiative, InitiativeService $service)
    {
        $this->initiative = $initiative;
        $this->service = $service;
    }

    public function index()
    {
//        return $this->initiative->getAll();
        return view('initiative.index');
    }

    public function find(Initiative $initiative)
    {
        return $initiative->toJson();
    }

    public function create()
    {
        return view('initiative.create');
    }

    public function store(StoreRequest $request)
    {
        $initiative = $this->service->createFromRequest($request);

        return response()->json($initiative);
    }
}
