<?php

namespace App\Models\Initiative\Tag;

use App\Models\Initiative\Tag;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Initiative\Tag\Other
 *
 * @property integer $tag_id
 * @property string $name
 * @property-read \App\Models\Initiative\Tag $tag
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Tag\Other whereTagId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Tag\Other whereName($value)
 * @mixin \Eloquent
 */
class Other extends Model
{
    protected $table = 'initiative_tags_other';

    protected $fillable = ['name'];

    public $timestamps = false;

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
