<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use stdClass;

/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $name
 * @property float $lat
 * @property float $lng
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $json
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereLng($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereJson($value)
 * @mixin \Eloquent
 */
class Location extends Model
{
    use Searchable;

    protected $table = 'locations';

    protected $fillable = [
        'name', 'lat', 'lng', 'json'
    ];

    protected $googleLocation;

    public function initiatives()
    {
        return $this->morphedByMany(Initiative::class, 'locatable');
    }

    public function events()
    {
        return $this->morphedByMany(Event::class, 'locatable');
    }

    /**
     * @return \Geocoder\Result\ResultInterface|\Geocoder\Result\Geocoded
     */
    public function getGoogleLocation()
    {
        if(!$this->googleLocation) {
            $geocode = \Geocoder::reverse($this->attributes['lat'], $this->attributes['lng']);
            $this->googleLocation = $geocode;
        }

        return $this->googleLocation;
    }

    /**
     * Returns true if Location's [lat, lng] point is within given boundaries.
     * Boundaries are in form stdObject{south: Float, west: Float, north: Float, east: Float}
     *
     * @param mixed $boundaries
     * @return bool
     */
    public function isWithinBounds($boundaries)
    {
        return $this->lat >= $boundaries->south && $this->lat <= $boundaries->north
            && $this->lng >= $boundaries->west && $this->lng <= $boundaries->east;
    }

}
