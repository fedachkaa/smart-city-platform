<?php

namespace App\Models;

use App\Enums\UserRequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserRequest extends Model
{
    /** @var array */
    protected $fillable = [
        'user_id',
        'city_id',
        'infrastructure_object_id',
        'title',
        'description',
        'system_notes',
        'status',
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
    public function infrastructureObject(): BelongsTo
    {
        return $this->belongsTo(InfrastructureObject::class, 'infrastructure_object_id');
    }

    /**
     * @return HasOne
     */
    public function photo(): HasOne
    {
        return $this->hasOne(CloudinaryMedia::class, 'user_request_id');
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
     * Scope a query to filter by creator (first name, last name, full name, email)
     */
    public function scopeSearchByCreator($query, $value)
    {
        if (!$value) {
            return $query;
        }

        return $query->whereHas('user', function ($q) use ($value) {
            $q->where('first_name', 'like', "%{$value}%")
                ->orWhere('last_name', 'like', "%{$value}%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$value}%"])
                ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$value}%"])
                ->orWhere('email', 'like', "%{$value}%");
        });
    }
}