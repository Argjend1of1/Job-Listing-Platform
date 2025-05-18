<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

//        query() -> allows chaining queries
        $employersQuery = Employer::query();

        if($query) {
            $employersQuery->where('name', 'like', "%$query%")
                ->orWhereHas('category', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%");
                });
        }else {
            $employersQuery->latest();
        }

        $employers = $employersQuery->simplePaginate(12);

        return view('company.index', [
            'employers' => $employers
        ]);
    }

    public function show($id)
    {
        $employer = Employer::with('job')->findOrFail($id);
        $jobs = $employer->job->all();

        return view('company.show', [
            'employer' => $employer,
            'jobs' => $jobs
        ]);
    }
}
