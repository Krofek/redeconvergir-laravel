<?php

namespace App\Models\Initiative;

use App\Models\Initiative;
use App\Models\Initiative\Audience\Other;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Initiative\Audience
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Initiative[] $initiatives
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Audience whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Audience whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Audience whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Audience whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Audience extends Model
{
    use CrudTrait;
    protected $table = 'audience';

    protected $fillable = ['name'];

    public function initiatives()
    {
        return $this->belongsToMany(Initiative::class, 'initiative_audience')->withPivot('name');
    }
    
}
