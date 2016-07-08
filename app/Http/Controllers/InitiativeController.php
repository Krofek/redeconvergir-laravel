<?php

namespace App\Http\Controllers;

use App\Interfaces\InitiativeRepositoryInterface;
use App\Models\Initiative;
use App\Services\InitiativeService;
use Illuminate\Http\Request;

use App\Http\Requests;

class InitiativeController extends Controller
{
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
        return $this->initiative->getAll();
    }

    public function find(Initiative $initiative)
    {
        return $initiative->toJson();
    }
}
