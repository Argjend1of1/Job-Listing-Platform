<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Inertia\Inertia;
use Inertia\Response;

//INERTIA COMPLETED!!
class TagController extends Controller
{
    public function __invoke(Tag $tag) : Response
    {
        $search = ($tag['name']);
        $jobs = $tag->jobs();

        return inertia('Index', [
            'jobs' => Inertia::scroll(fn () => $jobs->paginate(12)),
            'search' => $search ?? null
        ]);
    }
}
