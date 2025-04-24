<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'tab_id',
        'tab_title',
        'device_info',
        'logged_in_at',
        'logged_out_at',
        'last_active',
        'computer_name' // Add this
    ];

    protected $dates = [
        'logged_in_at',
        'logged_out_at',
        'last_active'
    ];
}
