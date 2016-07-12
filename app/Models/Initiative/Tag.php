<?php

namespace App\Models\Initiative;

use App\Models\Initiative;
use App\Models\Initiative\Tag\Other;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Initiative\Tag
 *
 * @property integer $id
 * @property string $name
 * @property integer $initiative_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Initiative $initiative
 * @property-read \App\Models\Initiative\Tag\Other $other
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Tag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Tag whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Tag whereInitiativeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    protected $table = 'initiative_tags';

    protected $fillable = ['name'];

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
        return $this->hasOne(Other::class, 'tag_id');
    }
}
