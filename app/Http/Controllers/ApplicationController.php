<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

//INERTIA COMPLETED
class ApplicationController extends Controller
{
    public function store($id)
    {
        $user = $this->getUser();

        if(!$user->resume) {
            return back()->with(
                'message', 'Please upload your resume before applying!'
            );
        }

        $alreadyApplied = $user->applications()
                               ->where('job_id', $id)
                               ->exists();

        if($alreadyApplied) {
            return back()->with(
                'message', 'You already applied for this job!'
            );
        }

        try {
            Application::create([
                'user_id' => $user->id,
                'job_id' => $id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

//        if the user had this particular job
            if ($user->bookmarkedJobs()->where('job_id', $id)->exists()) {
                $user->bookmarkedJobs()->detach($id);
            }


            return back()->with([
                'completed' => 'Application submitted successfully!'
            ]);
        }catch (\Exception $e) {
            // Optionally log for debugging
            Log::error('Application creation failed', [
                'user_id' => $user->id,
                'job_id'  => $id,
                'error'   => $e->getMessage(),
            ]);

            return back()->with(
                'error', 'An unexpected error occurred while applying. Please try again later.'
            );
        }
    }

    /*
     * Show all the applicants for a given job
     */
    public function show(Job $job)
    {
        Gate::authorize('manage', $job);

        $applications = Application::where('job_id', $job->id)
                                    ->with('user.resume')
                                    ->paginate(10);

        return inertia('applications/Show', [
            'applications' => $applications,
            'job' => $job
        ]);
    }

    private function getUser() : User
    {
        return User::with(['applications', 'resume'])
                   ->findOrFail((int) Auth::id());
    }
}
