<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

//        query => starts a query builder chain
        $jobsQuery = Job::query();

        if ($query) {
            $this->searchQuery($jobsQuery, $query);

        } else {
            $jobsQuery->latest(); // Sort by created_at DESC
        }
        $jobs = $jobsQuery->simplePaginate(12);

        return view('jobs.index', compact('jobs', 'query'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(JobRequest $request)
    {
        $attributes = $request->validated();

        $attributes['category_id'] = Auth::user()->employer->category_id;

        if(Auth::user()->role === 'superemployer') {
            $attributes['top'] = true;
        }

        $job = Auth::user()->employer->job()->create(
            Arr::except($attributes, 'tags')
        );

        if($attributes['tags']) {
            foreach (explode(',', strtolower($attributes['tags'])) as $tag) {
                $job->tag($tag);
            }
        }

        $job->load('employer');
        $job->load('tags');

        return response()->json([
            'message' => "Job Listed Successfully!",
            'jobs' => $job
        ]);
    }

    public function show(Job $job) {
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function top(Request $request) {
        $query = $request->input('q');
        $jobsQuery = Job::where('top', true);

        if($query) {
            $this->searchQuery($jobsQuery, $query);
        }else {
            $jobsQuery->latest();
        }

        $jobs = $jobsQuery->simplePaginate(12);

        return view('jobs.top', compact('jobs', 'query'));
    }

    public function more(Request $request) {
        $query = $request->input('q');
        $jobsQuery = Job::where('top', false);

        if($query) {
            $this->searchQuery($jobsQuery, $query);
        }else {
            $jobsQuery->latest();
        }

        $jobs = $jobsQuery->simplePaginate(12);

        return view('jobs.more', compact('jobs', 'query'));
    }

    public function searchQuery($jobsQuery, $query) {
        return $jobsQuery->where(function ($q) use ($query) {
            $q->where('title', 'like', "%$query%")
                ->orWhere('company', 'like', "%$query%")
                ->orWhere('location', 'like', "%$query%")
                ->orWhere('schedule', 'like', "%$query%")
                ->orWhere('about', 'like', "%$query%");
        })->orWhereHas('employer', function ($q) use ($query) {
            $q->where('name', 'like', "%$query%");
        });
    }
}
