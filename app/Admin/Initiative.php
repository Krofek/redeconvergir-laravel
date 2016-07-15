<?php 

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Admin\Initiative
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
 * @property-read mixed $logo
 * @property-read mixed $docs
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereContactId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereLogoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereDocUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereVideoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereAudienceSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereGroupSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereAreaSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereAcceptsVisits($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereLocationType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereLocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative wherePromoter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Admin\Initiative whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Initiative extends \App\Models\Initiative {


}
