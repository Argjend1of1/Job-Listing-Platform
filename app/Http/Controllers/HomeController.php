<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;

class HomeController extends Controller
{
    public function __invoke()
    {
        $topJobs = Job::where('top', true)
            ->latest()
            ->take(6)
            ->get();

        $otherJobs = Job::where('top', false)
            ->latest()
            ->take(9)
            ->get();

//        dd($otherJobs);

//        return $jobs;
        return view('index', [
            'topJobs' => $topJobs ?? null,
            'otherJobs' => $otherJobs ?? null,
            'tags' => Tag::latest()->simplePaginate(3)
        ]);
    }
}
