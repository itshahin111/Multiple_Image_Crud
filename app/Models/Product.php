<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'detail',
        'images'
    ];

    protected $casts = [
        'images' => 'array', // Images will be treated as an array
    ];
}
