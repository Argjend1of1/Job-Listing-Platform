<?php

namespace App\Observers;

use App\Events\User\UserRoleUpdated;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

/**
 * Add `ShouldHandleEventsAfterCommit` if you will deal with Database Transactions for this specific resource.
 * It will make sure to dispatch an event, only after the transactions is completed.
 */
class UserObserver /* implements ShouldHandleEventsAfterCommit */
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Log::info("New user, $user->name was created");
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->wasChanged('role')) {
            $oldRole = $user->getOriginal('role');
            $newRole = $user->role;

            event(new UserRoleUpdated($user, $oldRole, $newRole));
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
