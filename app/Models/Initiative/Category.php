<?php

namespace App\Models\Initiative;

use App\Models\Initiative;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Initiative\Category
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Initiative $initiative
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Category whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    protected $table = 'initiative_categories';

    public function initiative()
    {
        return $this->belongsTo(Initiative::class, 'initiative_id');
    }
}
