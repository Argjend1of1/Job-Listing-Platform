<?php

namespace App\Http\InertiaProps;

use Illuminate\Support\Facades\Storage;
use Inertia\PropertyContext;
use Inertia\ProvidesInertiaProperty;

class UserLogo implements ProvidesInertiaProperty
{
    public function __construct(protected $user) {}

    public function toInertiaProperty(PropertyContext $prop): mixed
    {
        return $this->user->logo
            ? Storage::url($this->user->logo)
            : asset('storage/logos/default-logo.png');
    }
}
