<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'price',
        'address',
        'description',
        'thumbnail_url',
        'status'
    ];
}