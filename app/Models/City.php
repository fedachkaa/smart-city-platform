<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'region',
        'latitude',
        'longitude',
        'population',
        'country_code',
        'created_at',
        'updated_at',
    ];
}