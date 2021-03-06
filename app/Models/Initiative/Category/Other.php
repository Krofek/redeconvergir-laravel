<?php

namespace App\Models\Initiative\Category;

use App\Models\Initiative;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Initiative\Category\Other
 *
 * @property integer $initiative_id
 * @property string $name
 * @property-read \App\Models\Initiative $initiative
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Category\Other whereInitiativeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Category\Other whereName($value)
 * @mixin \Eloquent
 */
class Other extends Model
{
    protected $table = 'initiative_categories_other';

    protected $fillable = ['name'];

    public $timestamps = false;

    public function initiative()
    {
        return $this->belongsTo(Initiative::class, 'initiative_id');
    }
}
