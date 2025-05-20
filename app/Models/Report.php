<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'user_id'
    ];

    public function job() : belongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function user() : belongsTo
    {
        return  $this->belongsTo(User::class);
    }
}
