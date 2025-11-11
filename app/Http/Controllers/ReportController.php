<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Report;
use App\Models\User;
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
        $user = $this->getUser();

//        omit duplicates
        $existingReport = $user->reports()
            ->where('job_id', $job->id)
            ->first();

        if ($existingReport) {
            return back()->with(
                'message', 'You have already reported this job. Our admins will check it shortly.'
            );
        }

//      disallowing reporting their own job
        if ($job->user_id === $user->id) {
            return back()->with(
                'message', 'You cannot report your own job.'
            );
        }

        Report::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with(
            'completed', 'Report Submitted Successfully. Will be checked by our admins!'
        );
    }

    public function getUser() : User
    {
        return User::with('reports')
                    ->findOrFail((int) Auth::id());
    }
}
