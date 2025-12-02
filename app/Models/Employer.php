<?php

namespace App\Models;

use Database\Factories\EmployerFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;


class Employer extends Model
{
    /** @use HasFactory<EmployerFactory> */
    use HasFactory;

    #[Scope]
    protected function withUserFilter(
        Builder $query,
        string $role = 'employer',
        ?string $search = null
    ): Builder
    {
        return $query->whereHas('user', function ($q) use ($role, $search) {
            $q->where('role', $role);

            if ($search) {
                $q->whereAny(['name', 'role'], 'like', "%{$search}%");
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
