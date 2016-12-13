<?php
namespace App\Repositories;

use App\Interfaces\LocationRepositoryInterface;
use App\Models\Location;

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

    public function mapMarkers()
    {
        return $this->location->with(['initiatives'])->get();
    }
}