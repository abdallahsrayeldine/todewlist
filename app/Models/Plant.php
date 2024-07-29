<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species',
        'water',
        'date',
        'soil',
        'drainage',
        'fertilizer',
        'sunlight',
        'humidity',
        'notes',
        'plant_path',
        'plant_pic',
        'user_id',
    ];
}
