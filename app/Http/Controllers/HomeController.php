<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use App\Models\User;
use App\Traits\JobFiltering;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

//INERTIA COMPLETE!!
class HomeController extends Controller
{
    use JobFiltering;
    public function __invoke()
    {
        $queryTop = Job::query();
        $queryOther = Job::query();

        if(Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
        }else {
            $user = null;
        }

        $topJobs = $this->queryBuilder(
            $queryTop, $user, true, 6
        );

        $otherJobs = $this->queryBuilder(
            $queryOther, $user, false, 9
        );

        return inertia('Index', [
            'topJobs' => $topJobs ?? null,
            'otherJobs' => $otherJobs ?? null,
            'tags' => Tag::latest()->simplePaginate(6)
        ]);
    }

    private function queryBuilder($query, ?User $user, bool $top, int $amount)
    {
        if($user) {
            $excludedIds = $this->removeFromDisplay();

            $query
                ->where('category_id', $user->category_id)
                ->whereNotIn('id', $excludedIds);
        }

        return $query
            ->where('top', $top)
            ->latest()
            ->with(['employer.user', 'tags'])
            ->take($amount)
            ->get();
    }
}
