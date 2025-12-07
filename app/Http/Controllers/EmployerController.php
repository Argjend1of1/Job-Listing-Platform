<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Services\EmployerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmployerController extends Controller
{
    public function __construct(protected EmployerService $employer){}

    public function index(Request $request): RedirectResponse | Response
    {
        $searchQuery = $request->input('q');

        /**
         * We should not pass the query on a scope.
         * The yellow line should be fixed on a future update by PhpStorm
         */
        $employers = Employer::withUserFilter(
            'employer', $searchQuery
        )->paginate(12);

        return inertia('employer/Index', [
            'employers' => Inertia::scroll(fn () => $employers),
            'query' => $searchQuery ?? ''
        ]);
    }

    public function update($id): RedirectResponse
    {
        $employer = $this->employer->get($id);

        return $employer->user->role === 'superemployer'
            ? $this->employer->demote($employer)
            : $this->employer->promote($employer);
    }

    public function destroy(string $id): RedirectResponse | Response
    {
        $employer = $this->employer->get($id);

        return $this->employer->delete($employer);
    }
}
