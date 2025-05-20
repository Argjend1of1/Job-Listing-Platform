<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return view('resume.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:4096'
        ]);

//        Store privately in storage/app/resumes
        $path = $request->file('resume')->store('resumes', 'local');
        $user = Auth::user();

//        Delete old resume if it exists
        if($user->resume) {
//            locally
            Storage::disk('local')->delete($user->resume->file_path);

//            database:
            $user->resume->delete();
        }

        Resume::create([
            'user_id' => Auth::user()->id,
            'file_path' => $path,
        ]);

        return response()->json([
            'message' => 'Resume Uploaded Successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Job $job) {
        $authUser = Auth::user();

        // Make sure user is authenticated and is an employer
        if (!$authUser || !$authUser->employer) {
            abort(403, 'Unauthorized: Not an employer.');
        }

        // Check if the employer owns the job
        $ownsJob = $authUser->employer->job()
            ->where('id', $job->id)
            ->exists();

        if (!$ownsJob) {
            abort(403, 'You do not own this job.');
        }

        if (!$user->resume->file_path || !Storage::disk('local')->exists($user->resume->file_path)) {
            abort(404, 'Resume not found.');
        }

        return Storage::disk('local')->download($user->resume->file_path);
    }

}
