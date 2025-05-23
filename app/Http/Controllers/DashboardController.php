<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
    public function show()
    {
        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'jobs' => $user->employer->job,
//            just for testing
            'message' => '(super)employer can access dashboard!'
        ]);
    }

    public function edit(Job $job)
    {
        $job->load('employer');

        if(Auth::user()->id !== $job->employer->user_id) {
            return redirect('/');
        }

        return view('dashboard.edit', [
            'job' => $job,
        ]);
    }

    public function update(Request $request, Job $job) {
        $request->validate([
            'title'       => 'required|string|max:255',
            'schedule'    => 'required|in:Full Time,Part Time', // customize as needed
            'about'       => 'required',
            'salary'      => 'required|string|max:100' // if salary is in string format like "$50,000 USD"
        ]);

        $job->update([
            'title' => $request->title,
            'schedule' => $request->schedule,
            'salary' => $request->salary
        ]);

        return response()->json([
            'message' => 'Job updated successfully!',
            'job'     => $job->fresh()->load('tags','employer'),
        ]);
//      reloading a fresh model instance for the job with its relations
    }

    public function destroy(Job $job) {
        $user = Auth::user();

//        if authenticated job must belong to you
        if($user->employer->id !== $job->employer->id) {
            return response()->json([
                'message' => "Unauthorized to remove others' jobs!"
            ], 403);
        }

        $job->delete();

        return response()->json([
            'message' => 'Listing deleted successfully!'
        ]);
    }
}
