<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Route extends Model
{
    /** @var array */
    protected $fillable = [
        'city_id',
        'name',
        'route',
        'created_by',
        'start_time',
    ];

    /** @var array */
    protected $casts = [
        'route' => 'array',
        'start_time' => 'datetime',
    ];

    /**
     * @return BelongsToMany
     */
    public function objects()
    {
        return $this->belongsToMany(InfrastructureObject::class, 'route_infrastructure_objects')
            ->withPivot('order')
            ->orderBy('pivot_order');
    }

    /**
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}