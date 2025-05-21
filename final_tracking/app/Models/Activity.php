<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    // Add the user_id and any other fields to the $fillable property
    protected $fillable = ['user_id', 'action', 'created_at'];

    // Alternatively, if you want to allow all fields, you can use $guarded
    // protected $guarded = [];
}
