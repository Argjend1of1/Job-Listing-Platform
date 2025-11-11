<?php

namespace App\Http\Controllers;

use App\Http\InertiaProps\UserLogo;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


//Inertia COMPLETED
class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = User::with('employer.job.tags')
                    ->findOrFail((int) Auth::id());

        return inertia('dashboard/Index', [
            'user' => $user,
            'logo' => new UserLogo($user),
            'jobs' => $user->employer->job
        ]);
    }

    public function edit(Job $job)
    {
        $job->load('employer');
        Gate::authorize('manage', $job);

        return inertia('dashboard/Edit', [
            'job' => $job
        ]);
    }

    public function update(Request $request, Job $job) {
        Gate::authorize('manage', $job);

        $request->validate([
            'title'       => 'required|string|max:255',
            'schedule'    => 'required|in:Full Time,Part Time',
            'about'       => 'required',
            'salary'      => 'required|string|max:100' // if salary is in string format like "$50,000 USD"
        ]);

        $job->update([
            'title' => $request->title,
            'schedule' => $request->schedule,
            'salary' => $request->salary,
            'about' => $request->about
        ]);

        return redirect('/dashboard')
                ->with('success', 'Listing updated successfully!');
    }

    public function destroy(Job $job) {
        Gate::authorize('manage', $job);

        $job->delete();

        return redirect('/dashboard')
                ->with('success', 'Listing deleted successfully!');
    }
}
