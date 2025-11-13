<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class EmployerController extends Controller
{
    public function index(Request $request): RedirectResponse | Response
    {
        $searchQuery = $request->input('q');

        $employers = Employer::withUserFilter(search: $searchQuery);

        return inertia('employer/Index', [
            'employers' => Inertia::scroll(fn () => $employers->paginate(12)),
            'query' => $searchQuery ?? ''
        ]);
    }

    public function update($id): RedirectResponse | Response
    {
        $employer = $this->getEmployer($id);

        if(!$employer)
            return back()->with(
                'message', 'Could not find company.'
            );

        if($employer->user->role === 'superemployer') {
            //if the role superemployer and we hit this method,
            //it means we want to demote the employer
            try {
                $employer->user->role = 'employer';
                $employer->user->save();

                return back()->with(
                    'message', 'Employer Demoted Successfully!'
                );
            }catch (\Exception $e) {
                Log::error('Employer demotion failed', [
                    'user' => $employer->user,
                    'employer' => $employer,
                    'error' => $e->getMessage()
                ]);
                return back()->with(
                    'error', 'Could not demote employer. Please try again!'
                );
            }

        }else {
            //else the role is employer, so the desire is promotion
            try {
                $employer->user->role = 'superemployer';
                $employer->user->save();

                return back()->with(
                    'message', 'Employer Promoted Successfully!'
                );

            }catch (\Exception $e) {
                Log::error('Employer promotion failed', [
                    'user' => $employer->user,
                    'employer' => $employer,
                    'error' => $e->getMessage()
                ]);
                return back()->with(
                    'error', 'Could not promote employer. Please try again!'
                );
            }
        }
    }

    public function destroy(string $id): RedirectResponse | Response
    {
        // You can now use $id to find and delete the employer
        $employer = $this->getEmployer($id);

        try {
            //precaution removal if cascadeOnDelete() does not work
            $employer->job()->delete(); //all the jobs by employer
            $employer->user->delete();  //his user data
            $employer->delete();        //employer data

            return back()->with(
                'message', 'Employer removed successfully!'
            );

        }catch (\Exception $e) {
            Log::error('Removal of employer failed', [
                'user' => $employer->user,
                'employer' => $employer,
                'error' => $e->getMessage(),
            ]);

            return back()->with(
                'error', 'Could not remove employer. Please try again.'
            );
        }
    }

    private function getEmployer($id): Employer
    {
        return Employer::with('user')
                       ->findOrFail($id);
    }
}
