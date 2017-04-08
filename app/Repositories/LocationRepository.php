<?php
namespace App\Repositories;

use App\Interfaces\LocationRepositoryInterface;
use App\Models\Location;
use App\Services\InitiativeService;
use App\Services\MapService;

class LocationRepository implements LocationRepositoryInterface
{
    /**
     * @var Location
     */
    protected $location;

    public function __construct()
    {
        $this->location = new Location();
    }

    public function getAll()
    {
        return $this->location->all();
    }

    public function find($id)
    {
        return $this->location->findOrFail($id);
    }

    public function mapMarkers($filters)
    {
        return $this->location
            ->with(['initiatives'])
            ->whereHas('initiatives.categories', function($query) use ($filters) {
                MapService::applyFilters($query, $filters);
            })
            ->get()
            ->keyBy('id')
            ->map(function (Location $marker) use ($filters){
                $initiatives = $marker->initiatives;
                $marker = collect($marker)->all();
                $marker['position'] = [
                    'lat' => (float) $marker['lat'],
                    'lng' => (float) $marker['lng']
                ];
                unset($marker['lat'], $marker['lng']);
                $marker['initiatives'] = InitiativeService::prepareForApi($initiatives)->all();
                return $marker;
            })->all();
    }
}