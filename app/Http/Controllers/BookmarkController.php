<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $jobs = Auth::user()->bookmarkedJobs()->get();

        return view('bookmark.index', compact('jobs'));
    }

    public function store(Job $job)
    {
        $user = Auth::user();
        if(!$user) {
            return response()->json([
                'message' => 'You must be authenticated to bookmark a job!'
            ], 401);
        }

        if($user->bookmarkedJobs()->where('job_id', $job->id)->exists()) {
            return response()->json([
                'message' => 'You already bookmarked this job!'
            ], 409);
        }

//      Insert into the saved_jobs table a row
//      where user_id = (current user) and
//      job_id = $job->id.
        $user->bookmarkedJobs()->attach($job->id);

        return response()->json([
            'message' => 'Bookmarked!'
        ]);
    }

    public function show(Job $job)
    {
        return view('bookmark.show', compact('job'));
    }

    public function destroy(Job $job)
    {
        $user = Auth::user();

        if (!$user->bookmarkedJobs()->where('job_id', $job->id)->exists()) {
            return response()->json([
                'message' => 'This job is not bookmarked by you.'
            ], 403);
        }

        $user->bookmarkedJobs()->detach($job->id);

        return response()->json([
            'message' => 'Job removed from bookmarks!'
        ]);
    }
}
