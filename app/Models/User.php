<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // **********
    // Eloquent
    // **********
    /**
     * @return BelongsTo
     */
    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    /**
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    // **********
    // Mutators
    // **********

    /**
     * @param $value
     * @return void
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = bcrypt('password');
    }

    // **********
    // Scopes
    // **********

    /**
     * @param $query
     * @param $roleName
     * @return mixed
     */
    public function scopeFilterByRole($query, $roleName): mixed
    {
        if ($roleName) {
            return $query->whereHas('roles', function ($query) use ($roleName) {
                $query->where('name', $roleName);
            });
        }

        return $query;
    }

    /**
     * @param $query
     * @param $status
     * @return mixed
     */
    public function scopeFilterByStatus($query, $status): mixed
    {
        return $query->where('status', $status);
    }

    /**
     * @param $query
     * @param $word
     * @return mixed
     */
    public function scopeFilterByEmailOrDNI($query, $word): mixed
    {
        return $query->where('email', 'LIKE', '%' . $word . '%')
                ->orWhere('dni', 'LIKE', '%' . $word . '%');
    }
}
