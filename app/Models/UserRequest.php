<?php

namespace App\Models;

use App\Enums\UserRequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRequest extends Model
{
    /** @var array */
    protected $fillable = [
        'user_id',
        'city_id',
        'district_id',
        'infrastructure_object_id',
        'title',
        'description',
        'system_notes',
        'status',
        'photo'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => UserRequestStatus::class,
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * @return BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    /**
     * @return BelongsTo
     */
    public function infrastructureObject(): BelongsTo
    {
        return $this->belongsTo(InfrastructureObject::class, 'infrastructure_object_id');
    }

    /**
     * Scope a query to filter by title.
     */
    public function scopeSearchByTitle($query, $title)
    {
        if ($title) {
            return $query->where('title', 'like', '%' . $title . '%');
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
     * Scope a query to filter by district id.
     */
    public function scopeOfDistrict($query, $district)
    {
        if ($district) {
            return $query->where('district_id', $district);
        }

        return $query;
    }
}