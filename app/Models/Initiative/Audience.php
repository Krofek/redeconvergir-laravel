<?php

namespace App\Models\Initiative;

use App\Models\Initiative;
use App\Models\Initiative\Audience\Other;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Initiative\Audience
 *
 * @property integer $id
 * @property string $name
 * @property integer $initiative_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Initiative $initiative
 * @property-read \App\Models\Initiative\Audience\Other $other
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Audience whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Audience whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Audience whereInitiativeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Audience whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Audience whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Audience extends Model
{
    protected $table = 'initiative_audience';

    public function initiative()
    {
        return $this->belongsTo(Initiative::class, 'initiative_id');
    }

    public function getNameAttribute($value)
    {
        return $value === 'other' ? $this->other->name : trans($value);
    }

    public function other()
    {
        return $this->hasOne(Other::class, 'audience_id');
    }
}
