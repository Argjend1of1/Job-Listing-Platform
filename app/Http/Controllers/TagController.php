<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function __invoke(Tag $tag)
    {
        $search = ($tag['name']);
        $jobs = $tag->jobs()->simplePaginate(12);

        return view('results',[
            'jobs' => $jobs,
            'search' => $search
        ]);
    }
}
