<?php

namespace App\Services;

use App\Contracts\JobServiceInterface;
use App\Models\Job;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class JobService implements JobServiceInterface
{
    public function filterJobs(User|null $user, ?string $query)
    {
        $jobsQuery = Job::query();

        if($user) {
            $excludedIds = $this->getExcludedJobs($user);
            $jobsQuery
                ->where('category_id', $user->category_id)
                ->whereNotIn('id', $excludedIds);
        }
        if ($query) $this->applySearch($jobsQuery, $query);

        return $jobsQuery->with(['employer.user', 'tags']);
    }

    public function storeJobs(User $user, array $attributes) : Job
    {
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

        if (!empty($attributes['tags'])) {
            foreach (explode(',', strtolower($attributes['tags'])) as $tag) {
                $job->tag($tag);
            }
        }

        return $job;
    }

    public function destroyJob(Job $job): void
    {
        DB::transaction(function () use ($job) {
            $reported = Report::where('job_id', $job->id)->first();
            $reported?->delete();

            $job->delete();
        });
    }

    public function applySearch($jobsQuery, string $query)
    {
        return $jobsQuery->whereAny([
            'title',
            'location',
            'schedule',
            'about'
        ], 'like', "%$query%")
        ->orWhereHas('employer', function ($q) use ($query) {
            $q->where('name', 'like', "%$query%");
        });
    }

    public function getExcludedJobs(User $user)
    {
        return $user
            ->reports()
            ->pluck('job_id')
            ->merge(
                $user
                    ->applications()
                    ->pluck('job_id')
            )
            ->unique();
//        unique added for the cases where a user can apply and report the
//        same job after some time for whatever reason. Just a PRECAUTION!
    }
}
