<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Authenticatable implements CanResetPasswordContract
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, CanResetPassword;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'city_id',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * @return HasMany
     */
    public function requests(): HasMany
    {
        return $this->hasMany(UserRequest::class, 'user_id');
    }

    /**
     * @return HasOne
     */
    public function photo(): HasOne
    {
        return $this->hasOne(CloudinaryMedia::class, 'user_id');
    }

    /**
     * @return int
     */
    public function getNoRequestsAttribute(): int
    {
        return $this->requests()->count();
    }

    /**
     * Scope a query to filter by first name, last name, full name, email
     */
    public function scopeSearchByNameEmail($query, $value)
    {
        if (!$value) {
            return $query;
        }

        return $query->where('first_name', 'like', "%{$value}%")
            ->orWhere('last_name', 'like', "%{$value}%")
            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$value}%"])
            ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$value}%"])
            ->orWhere('email', 'like', "%{$value}%");
    }
}
