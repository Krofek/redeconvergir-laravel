<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Initiative
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
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereContactId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereLogoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereDocUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereVideoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereAudienceSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereGroupSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereAreaSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereAcceptsVisits($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereLocationType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereLocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative wherePromoter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Initiative whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Initiative extends Model {

//    protected $table = 'Initiative';

}
