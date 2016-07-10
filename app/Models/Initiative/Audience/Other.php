<?php

namespace App\Models\Initiative\Audience;

use App\Models\Initiative\Audience;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Initiative\Audience\Other
 *
 * @property integer $audience_id
 * @property string $name
 * @property-read \App\Models\Initiative\Audience $tag
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Audience\Other whereAudienceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Audience\Other whereName($value)
 * @mixin \Eloquent
 */
class Other extends Model
{
    protected $table = 'initiative_audience_other';

    public function tag()
    {
        return $this->belongsTo(Audience::class, 'audience_id');
    }
}
