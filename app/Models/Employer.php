<?php

namespace App\Models;

use Database\Factories\EmployerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

class Employer extends Model
{
    /** @use HasFactory<EmployerFactory> */
    use HasFactory;

    public function scopeWithUserFilter(
        $query, string $role = 'employer' , string $search = null
    ){
        return $query->whereHas('user', function ($q) use ($search, $role) {
            $q->where('role', $role);

            if ($search) {
                $q->where('name', 'like', "%{$search}%");
                // Add more orWhere() conditions here if needed
            }
        })
        ->with('user')
        ->latest();
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function job(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
