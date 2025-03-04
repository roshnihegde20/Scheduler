<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'gender',
        'date_of_birth',
        'mobile_no',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
