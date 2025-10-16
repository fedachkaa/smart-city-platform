<?php

namespace App\Models;

use App\Enums\InfrastructureObjectStatus;
use App\Enums\InfrastructureObjectType;
use Database\Factories\InfrastructureObjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfrastructureObject extends Model
{
    /** @use HasFactory<InfrastructureObjectFactory> */
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'status',
        'latitude',
        'longitude',
        'description',
        'district',
        'created_by',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'type' => InfrastructureObjectType::class,
        'status' => InfrastructureObjectStatus::class,
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to filter by name.
     */
    public function scopeSearchByName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        }

        return $query;
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeOfType($query, $type)
    {
        if ($type) {
            return $query->where('type', $type);
        }

        return $query;
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeOfStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }

        return $query;
    }

    /**
     * Scope a query to filter by district.
     */
    public function scopeOfDistrict($query, $district)
    {
        if ($district) {
            return $query->where('district', 'like', '%' . $district . '%');
        }

        return $query;
    }
}
