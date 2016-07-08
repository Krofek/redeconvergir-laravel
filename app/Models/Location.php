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
 * @property string $street
 * @property string $city
 * @property integer $postal_code
 * @property string $country
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Initiative[] $initiatives
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereLng($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location wherePostalCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Location extends Model
{
    protected $table = 'locations';

    public function initiatives()
    {
        return $this->hasMany(Initiative::class, 'location_id');
    }
}
