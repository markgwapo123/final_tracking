<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'device_info',
        'logged_in_at',
    ];
    
}
