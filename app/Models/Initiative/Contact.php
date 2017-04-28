<?php

namespace App\Models\Initiative;

use App\Models\Initiative;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Initiative\Contact
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $other
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $facebook
 * @property string $website
 * @property int $initiative_id
 * @property-read \App\Models\Initiative $initiative
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Contact whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Contact whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Contact whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Contact wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Contact whereOther($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Contact whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Contact whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Initiative\Contact whereInitiativeId($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    use CrudTrait;
    protected $table = 'contacts';

    protected $fillable = [
        'name', 'email', 'phone', 'facebook', 'other', 'website'
    ];

    public function initiative()
    {
        return $this->belongsTo(Initiative::class, 'initiative_id');
    }
}
