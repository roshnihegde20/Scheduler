<?php

namespace App\Models;

use App\Models\UserDetail;
use App\Models\UserLocation;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'email',
        'registered_date',
    ];

    public function gender()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function location()
    {
        return $this->hasOne(UserLocation::class);
    }
}
