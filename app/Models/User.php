<?php

namespace App\Models;

use App\Observers\UserObserver;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'logo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
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
     * The event map for the model.
     *
     * @var array<string, string>
     */
//    protected $dispatchesEvents = [
//        'saved' => UserSaved::class,
//        'deleted' => UserDeleted::class,
//    ];

    public static function current(array $relations = []) : ?User
    {
        return self::with($relations)->find(auth()->id());
    }

    public function employer() : HasOne
    {
        return $this->hasOne(Employer::class);
    }

    public function resume(): HasOne
    {
        return $this->hasOne(Resume::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function reports() : HasMany {
        return $this->hasMany(Report::class);
    }

    public function bookmarkedJobs() : BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'saved_jobs')
            ->withTimestamps();
    }
}
