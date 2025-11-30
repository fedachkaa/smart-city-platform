<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CloudinaryMedia extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'cloudinary_media';

    /**
     * @var array
     */
    protected $fillable = [
        'public_id',
        'secure_url',
        'asset_id',
        'resource_type',
        'file_type',
        'user_request_id',
        'user_id',
    ];

    /**
     * @return BelongsTo
     */
    public function request(): BelongsTo
    {
        return $this->belongsTo(UserRequest::class, 'user_request_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}