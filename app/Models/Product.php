<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description', // Assuming you also want to allow mass assignment for other attributes
        'price',       // Add any other attributes that should be mass assignable
    ];
}

