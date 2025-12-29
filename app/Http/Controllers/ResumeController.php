<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

//INERTIA COMPLETE!!
class ResumeController extends Controller
{
    public function index() {
        return inertia('resume/Index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:4096'
        ]);

        /** @var User $user */
        $user = Auth::user();

//        Store privately in storage/app/resumes
        $path = $request->file('resume')
                        ->store('resumes', 'local');

        try {
//            Delete old resume if it exists
            if($user->resume) {
//              locally:
                Storage::disk('local')
                        ->delete($user->resume->file_path);

//              database:
                $user->resume->delete();
            }

            Resume::create([
                'user_id' => Auth::id(),
                'file_path' => $path,
            ]);

            return redirect('/jobs')->with(
                'completed', 'Resume Uploaded Successfully. Apply for your next job!'
            );

        }catch (\Exception $e) {
            Log::error('Resume upload failed!', [
                'user_id' => $user->id,
                'resume'  => $request->file('resume'),
                'error'   => $e->getMessage(),
            ]);

            return back()->withErrors([
                'error' => 'An unexpected error occurred. Please try again later.'
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Job $job) {
        $authUser = $this->getUser();

        if (!$authUser->employer) {
            abort(403, 'Unauthorized: Not an employer.');
        }

        // Check if the employer owns the job
        $ownsJob = $authUser->employer->job()
            ->where('id', $job->id)
            ->exists();

        if (!$ownsJob) {
            abort(403, 'You do not own this job.');
        }

        if (!$user->resume ||
            !$user->resume->file_path ||
            !Storage::disk('local')->exists($user->resume->file_path)
        ) {
            return back()->with(
                'error', 'An internal  problem occurred. Please try againlater.'
            );
        }

        return Storage::disk('local')->download($user->resume->file_path);

//        alternative:
//        return response()->download(storage_path(
//            "app/private/{$user->resume->file_path}"),
//            "applicant-resume-$user->id.pdf"
//        );
    }

    public function getUser() : User
    {
        return User::with('employer')
                    ->findOrFail((int) Auth::id());
    }

}
