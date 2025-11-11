<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//Inertia COMPLETED
class BookmarkController extends Controller
{
    public function index()
    {
        return inertia('bookmarks/Index', [
            'jobs' => $this->getUser()
                           ->bookmarkedJobs()
                           ->with(['employer.user', 'tags'])
                           ->get()
        ]);
    }

    public function store(Job $job)
    {
        $user = $this->getUser();

        if($user->bookmarkedJobs()->where('job_id', $job->id)->exists())
        {
            return back()->with(
                'message', 'You already bookmarked this job!'
            );
        }

//      Insert into the saved_jobs table a row
//      where user_id = (current user) and
//      job_id = $job->id.
        $user->bookmarkedJobs()->attach($job->id);

        return back()->with('completed', 'Bookmarked Successfully!');
    }

    public function show(Job $job)
    {
        $job->load('employer');
        return inertia('bookmarks/Show', compact('job'));
//        return view('bookmark.show', compact('job'));
    }

    public function destroy(Job $job)
    {
        $user = $this->getUser();

        if (!$user->bookmarkedJobs()->where('job_id', $job->id)->exists()) {
            return back()->with(
                'message', 'This job is not bookmarked by you.'
            );
        }

//        RAW QUERY(ex.):
//        DELETE FROM saved_jobs
//        WHERE user_id = 1
//        AND job_id = 5;
        $user->bookmarkedJobs()->detach($job->id);

        return redirect('/bookmarks')->with(
            'completed', 'Successfully removed job from bookmarks!'
        );
    }

    private function getUser() {
        /** @var User $user */
        return User::findOrFail((int) Auth::id());
    }
}
