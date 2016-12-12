<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Location
 *
 * @property integer $id
 * @property string $name
 * @property float $lat
 * @property float $lng
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $json
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Initiative[] $initiatives
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
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
    protected $table = 'locations';

    protected $fillable = [
        'name', 'lat', 'lng', 'json'
    ];

    protected $googleLocation;

    public function initiatives()
    {
        return $this->belongsToMany(Initiative::class, 'initiative_location');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_initiative');
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

}
