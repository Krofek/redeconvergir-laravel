<?php

namespace App\Models;

use App\Models\Initiative\Audience;
use App\Models\Initiative\Category;
use App\Models\Initiative\Category\Other;
use App\Models\Initiative\Tag;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Initiative
 *
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 * @property string $description
 * @property integer $status
 * @property integer $contact_id
 * @property string $url
 * @property string $logo_url
 * @property string $doc_url
 * @property string $video_url
 * @property string $start_at
 * @property integer $audience_size
 * @property integer $group_size
 * @property integer $area_size
 * @property boolean $accepts_visits
 * @property boolean $location_type
 * @property integer $location_id
 * @property string $promoter
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Initiative\Category $category
 * @property-read \App\Models\Initiative\Category\Other $otherCategory
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Initiative\Tag[] $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Initiative\Audience[] $audience
 * @property-read \App\Models\Contact $contact
 * @property-read \App\Models\Location $location
 * @property-read mixed $category_name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereContactId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereLogoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereDocUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereVideoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereAudienceSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereGroupSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereAreaSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereAcceptsVisits($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereLocationType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereLocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative wherePromoter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $logo
 * @property-read \Illuminate\Database\Eloquent\Collection $docs
 */
class Initiative extends Model
{
    protected $table = 'initiatives';

    protected $fillable = [
        'name', 'category_id', 'contact_id', 'url', 'logo_url', 'doc_url', 'video_url', 'start_at', 'audience_size',
        'group_size', 'area_size', 'accepts_visits', 'location_type', 'location_id'
    ];

    protected $appends = [
        'category_name'
    ];

    /* ******************************************
     * ********** MODEL RELATIONS ***************
     * ******************************************/

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
        return $this->hasMany(Tag::class, 'initiative_id');
    }

    public function audience()
    {
        return $this->hasMany(Audience::class, 'initiative_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /* ******************************************
     * ********** MODEL ACCESSORS ***************
     * ******************************************/

    public function getCategoryNameAttribute($value)
    {
        return $this->category->name === 'other' ? $this->otherCategory->name : trans('categories.' . $value);
    }

    public function getAudienceSizeAttribute($value)
    {
        return trans(config('rede_initiative.audience_size')[$value]);
    }

    public function getAcceptsVisitsAttribute($value)
    {
        return trans(config('rede_initiative.accepts_visits')[$value]);
    }

    public function getLocationTypeAttribute($value)
    {
        return trans(config('rede_initiative.location_type')[$value]);
    }

    public function getStatusAttribute($value)
    {
        return trans(config('rede_initiative.status')[$value]);
    }

    public function getLogoAttribute()
    {
        $path = 'initiative/' . $this->attributes['id'] . '/logo';
        return $this->attributes['logo_url'] ?: \Storage::url($path);
    }

    public function getDocsAttribute()
    {
        $docs = collect();

        if ($this->attributes['doc_url']) $docs->push($this->attributes['doc_url']);

        $dir = 'initiative/' . $this->attributes['id'] . '/docs';

        if ($files = \Storage::files($dir)) {
            foreach ($files as $file) $docs->push(\Storage::url($file));
        }

        return $docs;
    }
}
