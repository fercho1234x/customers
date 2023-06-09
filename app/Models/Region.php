<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use HasFactory, SoftDeletes;

    // **********
    // Eloquent
    // **********

    /**
     * @return HasMany
     */
    public function communes(): HasMany
    {
        return $this->hasMany(Commune::class);
    }
}
