<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $employersQuery = Employer::with(['user', 'category']);

        if($query) {
            $employersQuery->where('name', 'like', "%$query%")
                ->orWhereHas('category', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%");
                });
        }else {
            $employersQuery->latest();
        }

        return inertia('company/Index', [
            'employers' => Inertia::scroll(fn () => $employersQuery->paginate(12)),
            'query' => $query ?? ''
        ]);
    }

    public function show($id)
    {
        /** @var Employer $employer */
        $employer = Employer::findOrFail($id);

        /** @var LengthAwarePaginator<int, Job> $jobs */
        $jobs = $employer->job()->with('tags')->paginate(12);

        return inertia('company/Show', [
            'employer' => $employer,
            'jobs' => Inertia::scroll(fn () => $jobs),
        ]);
    }
}
