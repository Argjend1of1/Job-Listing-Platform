<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke()
    {
        //display jobs based on the user's selected category, if the user is authenticated, else display without that query
        $queryTop = Job::query();
        $queryOther = Job::query();
        if(Auth::user()) {
            $queryTop->where('category_id', Auth::user()->category_id);
            $queryOther->where('category_id', Auth::user()->category_id);
        }

        $topJobs = $queryTop->where('top', true)
            ->latest()
            ->take(6)
            ->get();

        $otherJobs = $queryOther->where('top', false)
            ->latest()
            ->take(9)
            ->get();

        return view('index', [
            'topJobs' => $topJobs ?? null,
            'otherJobs' => $otherJobs ?? null,
            'tags' => Tag::latest()->simplePaginate(6)
        ]);
    }
}
