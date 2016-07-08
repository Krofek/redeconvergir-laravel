<?php

namespace App\Models\Initiative\Category;

use App\Models\Initiative;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Initiative\Category\Other
 *
 * @property string $name
 * @property integer $initiative_id
 * @property-read \App\Models\Initiative $initiative
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Category\Other whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Category\Other whereInitiativeId($value)
 * @mixin \Eloquent
 */
class Other extends Model
{
    protected $table = 'initiative_categories_other';

    public function initiative()
    {
        return $this->belongsTo(Initiative::class, 'initiative_id');
    }
}
