<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRole extends Model
{
    use HasFactory;

    /** @var string */
    protected $table = 'user_roles';

    /** @var bool */
    public $timestamps = false;

    /** @var string[] */
    protected $fillable = [
        'name',
    ];

    const USER_ROLE_GUEST = 'Guest';
    const USER_ROLE_OPERATOR = 'Operator';
    const USER_ROLE_ADMIN = 'Administrator';

    const ALLOWED_ADMIN_ROLES = [
        self::USER_ROLE_OPERATOR,
        self::USER_ROLE_ADMIN,
    ];

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}