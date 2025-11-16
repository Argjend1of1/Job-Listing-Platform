<?php
namespace App\Contracts;

use App\Models\Job;
use App\Models\User;
interface JobServiceInterface
{
    public function filterJobs(User|null $user, ?string $query );
    public function storeJobs (User $user, array $attributes);
    public function destroyJob(Job $job);
}
