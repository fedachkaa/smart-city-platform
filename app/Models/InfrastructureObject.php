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
}
