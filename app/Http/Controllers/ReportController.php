<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index() {
        $reports = Report::latest()
            ->with('job.employer.user')
            ->get();

        return view('reports.index', compact('reports'));
    }

    public function store(Job $job)
    {
        $user = Auth::user();

        if(!$user) {
            return response()->json([
                'message' => 'You must be logged in to report a job!'
            ], 401);
        }

//        omit duplicates
        $existingReport = Report::where('user_id', $user->id)
            ->where('job_id', $job->id)
            ->first();

        if ($existingReport) {
            return response()->json([
                'message' => 'You have already reported this job. Our admins will check it shortly.'
            ], 409);
        }

//      disallowing reporting their own job
        if ($job->user_id === $user->id) {
            return response()->json([
                'message' => 'You cannot report your own job.'
            ], 403);
        }

        Report::create([
            'user_id' => $user->id,
            'job_id' => $job->id
        ]);

        return response()->json([
            'message' => 'Report Submitted Successfully. Will be checked by our admins!'
        ]);
    }
}
