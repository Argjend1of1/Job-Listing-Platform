<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'jobs' => $user->employer->job
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
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

//      send an email to the user through queues

        return response()->json([
            'message' => 'Job updated successfully!',
            'job'     => $job->fresh()->load('tags','employer'),
        ]);
//      reloading a fresh model instance for the job with its relations
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job) {
        $job->delete();

        return response()->json([
            'message' => 'Listing deleted successfully!'
        ]);
    }
}
