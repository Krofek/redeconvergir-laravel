<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User\Profile
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $bio
 * @property string $photo_url
 * @property string $website
 * @property string $facebook
 * @property string $twitter
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User\Profile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User\Profile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User\Profile whereBio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User\Profile wherePhotoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User\Profile whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User\Profile whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User\Profile whereTwitter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User\Profile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Profile extends Model
{
    protected $table = 'user_profiles';

    protected $fillable = [];

    protected $dates = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
