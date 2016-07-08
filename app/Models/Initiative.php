<?php

namespace App\Models;

use App\Contact;
use App\Models\Initiative\Category;
use App\Models\Initiative\Category\Other;
use App\Models\Initiative\Tag;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Initiative
 *
 * @property integer $id
 * @property string $name
 * @property string $promoter
 * @property string $description
 * @property string $url
 * @property string $logo_url
 * @property string $doc_url
 * @property string $video_url
 * @property integer $visitors
 * @property integer $group_size
 * @property integer $area_size
 * @property string $start_at
 * @property integer $category_id
 * @property integer $location_id
 * @property integer $contact_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Initiative\Category $category
 * @property-read \App\Models\Initiative\Category\Other $otherCategory
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Initiative\Tag[] $tags
 * @property-read \App\Contact $contact
 * @property-read \App\Models\Location $location
 * @property-read mixed $category_name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative wherePromoter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereLogoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereDocUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereVideoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereVisitors($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereGroupSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereAreaSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereLocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereContactId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Initiative extends Model
{
    protected $table = 'initiatives';

    protected $fillable = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function otherCategory()
    {
        return $this->hasOne(Other::class, 'initiative_id');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'category_id');
    }

    public function contact()
    {
        return $this->hasOne(Contact::class, 'contact_id');
    }

    public function location()
    {
        return $this->hasOne(Location::class, 'location_id');
    }

    public function getCategoryNameAttribute($value)
    {
        return $this->category->name === 'other' ? $this->otherCategory->name : trans($value);
    }
}
