<?php

namespace App\Listeners\User;

use App\Events\User\UserRoleUpdated;
use Illuminate\Support\Facades\Log;

class NotifyRoleChange /*implements ShouldQueue */
{
//    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserRoleUpdated $event): void
    {
        Log::info("User {$event->user->id} role changed from $event->oldRole to $event->newRole");
    }
}
