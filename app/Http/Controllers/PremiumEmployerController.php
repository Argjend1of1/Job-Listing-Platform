<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PremiumEmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->input('q');
        $premiumEmployers = Employer::withUserFilter(
            'superemployer', $searchQuery
        );

        return inertia('employer/IndexPremium', [
            'employers' => Inertia::scroll(fn () => $premiumEmployers->paginate(12)),
            'query' => $searchQuery ?? ''
        ]);
    }
}
