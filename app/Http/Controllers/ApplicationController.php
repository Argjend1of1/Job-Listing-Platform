<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store($id)
    {
        $user = Auth::user();
        if(!$user) {
            return response()->json([
                'message' => 'You need to be logged in to apply for this job!'
            ], 401);
        }

        if(!$user->resume) {
            return response()->json([
                'message' => 'Please upload your resume before applying!'
            ], 422);
        }

        $alreadyApplied = Application::where('user_id', $user->id)
            ->where('job_id', $id)
            ->exists();

        if($alreadyApplied) {
            return response()->json([
                'message' => 'You already applied for this Job!'
            ], 404);
        }

        Application::create([
            'user_id' => $user->id,
            'job_id' => $id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'message' => 'Application submitted successfully!'
        ]);
    }

    public function show(Job $job)
    {
        if($job->employer_id !== Auth::user()->employer->id) {
            abort(403, 'Unauthorized access.');
        }

        $applications = Application::where('job_id', $job->id)
            ->with('user.resume')
            ->simplePaginate(10);
//        avoidance of lazy loading (n + 1) for user and his resume

        return view('dashboard.show', [
            'applications' => $applications,
            'job' => $job
        ]);
    }
}
