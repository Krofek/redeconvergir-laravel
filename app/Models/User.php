<?php

namespace App\Models;

use App\Models\User\Profile;
use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User\Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Initiative[] $initiatives
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read \Illuminate\Database\Eloquent\Collection|\Backpack\PermissionManager\app\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Backpack\PermissionManager\app\Models\Permission[] $permissions
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User role($roles)
 * @property string $api_token
 * @property bool $is_admin
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereApiToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereIsAdmin($value)
 */
class User extends Authenticatable
{
    use CrudTrait;
    use HasRoles;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    protected $casts = [
        'is_admin' => 'boolean'
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }
    
    public function initiatives()
    {
        return $this->belongsToMany(Initiative::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_user');
    }
    
}
