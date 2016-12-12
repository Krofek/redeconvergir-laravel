<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Event
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $website
 * @property string $start_at
 * @property string $end_at
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Initiative[] $initiatives
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereEndAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    use CrudTrait;
    protected $table = 'events';

    protected $fillable = ['name', 'start_at', 'end_at', 'website', 'description'];

    /**
     * Relations
     */
    public function initiatives()
    {
        return $this->belongsToMany(Initiative::class, 'event_initiative');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'event_location');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }
}
