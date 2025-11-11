<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Check if the authenticated user can manage a certain job.
     */
    public function manage(User $authUser, Job $job) : bool
    {
        return $authUser->employer->id === $job->employer_id;
    }
}
