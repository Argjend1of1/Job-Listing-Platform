<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait JobFiltering
{
    //extracts the IDs of the jobs the user has applied or reported to, so we can remove them from his UI.
    public function removeFromDisplay() {
        $user = Auth::user();
        return $user
            ->reports()
            ->pluck('job_id')
            ->merge(
                $user
                    ->applications()
                    ->pluck('job_id')
            )
            ->unique();
//        unique added for the cases where a user can apply and report the
//        same job after some time for whatever reason. Just a PRECAUTION!
    }
}
