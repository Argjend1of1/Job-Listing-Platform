<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Models\Report;
use App\Models\User;
use App\Traits\JobFiltering;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

//INERTIA COMPLETED
class JobController extends Controller
{
    use JobFiltering;

    public function index(Request $request)
    {
        [
            'jobsQuery' => $jobsQuery,
            'query' => $q
        ] = $this->displayJobsQuery($request);

        $jobs = $jobsQuery->latest();

        return Inertia::render('jobs/Index', [
            'jobs' => Inertia::scroll(fn () => $jobs->paginate(12)),
            'query' => $q,
        ]);
    }

    public function create() : ResponseFactory|Response
    {
        return inertia('jobs/Store');
    }

    public function store(JobRequest $request) : RedirectResponse
    {
        $attributes = $request->validated();
        $user = $this->getUser();

        $attributes['category_id'] = $user->employer->category_id;

        if($user->role === 'superemployer') {
            $attributes['top'] = true;
        }

        $job = $user->employer->job()->create(
            Arr::except($attributes, 'tags')
        );

        if($attributes['tags']) {
            foreach (explode(',', strtolower($attributes['tags'])) as $tag) {
                $job->tag($tag);
            }
        }

        return redirect('/dashboard')
            ->with('success', "Job Listed Successfully!");
    }

    public function show(Job $job) : ResponseFactory|Response
    {
        $job->load('employer');

        return inertia('jobs/Show', compact('job'));
    }

    public function destroy(Job $job) : RedirectResponse
    {
        try {
            $reported = Report::where('job_id', $job->id)->first();
            if ($reported !== null) $reported->delete();

            $job->delete();

            return redirect('/jobs')->with(
                'completed', 'Job deleted successfully!'
            );
        }catch (\Exception $e) {
            Log::error('Could not remove job with the id: ' . $job->id);

            return redirect('/jobs')->with(
                'error', 'An unexpected error occurred while removing this job. Please try again later.'
            );
        }
    }

    public function top(Request $request) : ResponseFactory|Response
    {
        [
            'jobsQuery' => $jobsQuery,
            'query' => $q
        ] = $this->displayJobsQuery($request);

        $jobs = $jobsQuery->where('top', true);

        return Inertia::render('jobs/Top', [
            'jobs' => Inertia::scroll(fn () => $jobs->paginate(12)),
            'query' => $q
        ]);
    }

    public function more(Request $request) : ResponseFactory|Response
    {
        [
            'jobsQuery' => $jobsQuery,
            'query' => $q
        ] = $this->displayJobsQuery($request);

        $jobs = $jobsQuery->where('top', false);

        return Inertia::render('jobs/More', [
            'jobs' => Inertia::scroll(fn () => $jobs->paginate(12)),
            'query' => $q
        ]);
    }

    public function displayJobsQuery(Request $request) : array
    {
        /** @var User $user */
        $user = Auth::user();

        $q = $request->input('q');
        $jobsQuery = Job::query();

        if($user) {
            $excludedIds = $this->removeFromDisplay();
            $jobsQuery
                ->where('category_id', $user->category_id)
                ->whereNotIn('id', $excludedIds);
        }

        if($q) $this->searchQuery($jobsQuery, $q);

        return [
            'jobsQuery' => $jobsQuery->with(['employer.user', 'tags']),
            'query' => $q
        ];
    }

    public function searchQuery($jobsQuery, $query)
    {
        return $jobsQuery->where(function ($q) use ($query) {
            $q->where('title', 'like', "%$query%")
                ->orWhere('location', 'like', "%$query%")
                ->orWhere('schedule', 'like', "%$query%")
                ->orWhere('about', 'like', "%$query%")
                ->orWhereHas('employer', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%");
                });
        });
    }

    public function getUser() : User
    {
        return User::with('employer')
                    ->findOrFail((int) Auth::id());
    }
}
