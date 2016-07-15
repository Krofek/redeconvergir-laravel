<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contact
 *
 * @property integer $id
 * @property string $name
 * @property string $street
 * @property string $city
 * @property integer $postal_code
 * @property string $country
 * @property string $email
 * @property string $phone
 * @property string $other
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact wherePostalCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereOther($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'name', 'street', 'city', 'postal_code', 'country', 'email', 'phone', 'other'
    ];
}
