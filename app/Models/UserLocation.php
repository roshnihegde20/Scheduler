<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    protected $table = 'user_location';
    
    protected $fillable = [
        'user_id',
        'street',
        'state',
        'country',
        'pincode',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
