<?php

namespace App\Http\Controllers;

use App\Contracts\JobServiceInterface;
use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

//INERTIA COMPLETED
class JobController extends Controller
{
    public function __construct(private JobServiceInterface $jobService){}

    public function index(Request $request): Response
    {
        $q = $request->input('q');

        $jobs = $this->jobService
            ->filterJobs(User::current(['employer']), $q)
            ->latest();

        return Inertia::render('jobs/Index', [
            'jobs' => Inertia::scroll(fn () => $jobs->paginate(12)),
            'query' => $q ?? '',
        ]);
    }

    public function create() : ResponseFactory|Response
    {
        return inertia('jobs/Store');
    }

    public function store(JobRequest $request) : RedirectResponse
    {
        $this->jobService->storeJobs(
            User::current(['employer']),
            $request->validated(),
        );

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
            $this->jobService->destroyJob($job);

            return redirect('/jobs')->with(
                'completed', 'Job deleted successfully!'
            );
        }catch (\Exception $e) {
            Log::error('Could not remove job.', [
                'user' => User::current(),
                'job' => $job->id,
                'error' => $e->getMessage(),
            ]);

            return redirect('/jobs')->with(
                'error', 'An unexpected error occurred while removing this job. Please try again later.'
            );
        }
    }

    public function top(Request $request) : ResponseFactory|Response
    {
        $q = $request->input('q');
        $jobs = $this->jobService
            ->filterJobs(User::current(), $q)
            ->where('top', true);

        return Inertia::render('jobs/Top', [
            'jobs' => Inertia::scroll(fn () => $jobs->paginate(12)),
            'query' => $q ?? ''
        ]);
    }

    public function more(Request $request) : ResponseFactory|Response
    {
        $q = $request->input('q');
        $jobs = $this->jobService
            ->filterJobs(User::current(), $q)
            ->where('top', false);

        return Inertia::render('jobs/More', [
            'jobs' => Inertia::scroll(fn () => $jobs->paginate(12)),
            'query' => $q ?? ''
        ]);
    }
}
