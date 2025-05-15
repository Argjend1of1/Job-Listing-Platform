<?php

namespace App\Models;

use Database\Factories\JobFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Job extends Model
{
    /** @use HasFactory<JobFactory> */
    use HasFactory;

    public function employer() : BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

//    only insert tags if not currently present
    public function tag(string $name)
    {
        $tag = Tag::firstOrCreate(['name' => $name]);

        $this->tags()->attach($tag);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }
}
