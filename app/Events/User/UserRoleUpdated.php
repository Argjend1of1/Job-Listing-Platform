<?php

namespace App\Events\User;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRoleUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;
    public string $oldRole;
    public string $newRole;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, string $oldRole, string $newRole)
    {
        $this->user = $user;
        $this->oldRole = $oldRole;
        $this->newRole = $newRole;
    }

//    /**
//     * Get the channels the event should broadcast on.
//     *
//     * @return array<int, Channel>
//     */
//    public function broadcastOn(): array
//    {
//        return [
//            new PrivateChannel('channel-name'),
//        ];
//    }
}
