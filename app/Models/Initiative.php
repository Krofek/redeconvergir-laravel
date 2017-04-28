<?php

namespace App\Models;

use App\Models\Initiative\Audience;
use App\Models\Initiative\Category;
use App\Models\Initiative\Contact;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Models\Initiative
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $status
 * @property string $url
 * @property string $logo_url
 * @property string $video_url
 * @property string $start_at
 * @property int $audience_size
 * @property int $group_size
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $area_size
 * @property bool $location_type
 * @property string $cover_photo_url
 * @property string $short_description
 * @property string $keywords
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Initiative\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Initiative\Audience[] $audience
 * @property-read \App\Models\Initiative\Contact $contact
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read mixed $audience_size_value
 * @property-read mixed $status_value
 * @property-read mixed $logo
 * @property-read mixed $location_type_value
 * @property-read mixed $audience_other
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereLogoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereVideoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereAudienceSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereGroupSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereAreaSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereLocationType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereCoverPhotoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereShortDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereKeywords($value)
 * @mixin \Eloquent
 * @property int $user_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative whereUserId($value)
 */
class Initiative extends Model
{
    use CrudTrait, Searchable;

    protected $table = 'initiatives';

    protected $fillable = [
        'name', 'url', 'logo_url', 'cover_photo_url', 'start_at', 'audience_size',
        'group_size', 'area_size', 'location_type', 'location_id', 'contact_id', 'description', 'status',
        'keywords', 'short_description'
    ];

    protected $notNullables = ['contact_id', 'location_id', 'category_id', 'audience_id', 'name'];

    /* ******************************************
     * ********** MODEL RELATIONS ***************
     * ******************************************/

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'initiative_category');
    }
    
    public function users()
    {
        return $this->belongsToMany(User::Class);
    }

    public function audience()
    {
        return $this->belongsToMany(Audience::class, 'initiative_audience')->withPivot('name');
    }

    public function contact()
    {
        return $this->hasOne(Contact::class, 'initiative_id');
    }

    public function locations()
    {
        return $this->morphToMany(Location::class, 'locatable');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_initiative');
    }

    public function delete()
    {
        $this->locations()->detach();
        return parent::delete();
    }

    /* ******************************************
     * ********** MODEL ACCESSORS ***************
     * ******************************************/

//    public function getCategoryNameAttribute($value)
//    {
//        return $this->category->name === 'other' ? $this->otherCategory->name : trans('categories.' . $value);
//    }

    public function getAudienceSizeValueAttribute($value)
    {
        return trans(config('initiatives.audience_size')[$value]);
    }

    public function getStatusValueAttribute($value)
    {
        return trans(config('initiatives.status')[$value]);
    }

    public function getLogoAttribute()
    {
        $path = 'initiative/' . $this->attributes['id'] . '/logo';
        return $this->attributes['logo_url'] ?: \Storage::url($path);
    }

    public function getLocationTypeValueAttribute($value)
    {
        return trans(config('initiatives.location_type')[$value]);
    }

    public function getAudienceOtherAttribute()
    {
        if(!$this->audience->where('id', config('initiatives.audience_other_id'))){
            return $this->audience->where('id', config('initiatives.audience_other_id'))->first()->pivot->name;
        }else{
            return null;
        }
    }

    /**
     * Mutators
     */
    public function setLogoUrlAttribute($value)
    {
        $attribute_name = "logo_url";
        $disk = "public";
        $destination_path = "uploads/logos";

        // if the image was erased or new one uploaded, delete old one
        if ($value==null || (isset($this->{$attribute_name}) && starts_with($value, 'data:image'))) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        if (starts_with($value, 'data:image'))
        {
            $w = config('initiatives.images.logo.size');
            $image = \Image::make($value)->resize($w, $w);
            $filename = md5($value.time()).'.jpg';
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
        }
    }

    public function setCoverPhotoUrlAttribute($value)
    {
        $attribute_name = "cover_photo_url";
        $disk = "public";
        $destination_path = "uploads/covers";

        // if the image was erased or new one uploaded, delete old one
        if ($value==null || (isset($this->{$attribute_name}) && starts_with($value, 'data:image'))) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        if (starts_with($value, 'data:image'))
        {
            $w = config('initiatives.images.cover_photo.width');
            $h = config('initiatives.images.cover_photo.height');
            $image = \Image::make($value)->resize($w, $h);
            $filename = md5($value.time()).'.jpg';
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
        }
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = array_only($this->toArray(), ['name', 'short_description']);
        $array['keywords'] = array_map(function($word) {
            return trim($word);
        }, explode(',', $this->keywords));
        $array['locations'] = collect($this->locations)->map(function (Location $location){
            $collection = collect($location);
            $collection['position'] = [(float) $location->lng, (float) $location->lat];
            return $collection->only(['name', 'position'])->all();
        })->toArray();

        return $array;
    }
}
