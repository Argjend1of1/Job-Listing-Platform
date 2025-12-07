<?php

namespace App\Services;

use App\Models\Employer;
use Illuminate\Http\RedirectResponse;

class EmployerService
{
    public function demote(Employer $employer): RedirectResponse
    {
        $employer->user->update([
            'role' => 'employer'
        ]);

        return back()->with(
            'message', 'Employer Demoted Successfully!'
        );
    }

    public function promote(Employer $employer): RedirectResponse
    {
        $employer->user->update([
            'role' => 'superemployer'
        ]);

        return back()->with(
            'message', 'Employer Promoted Successfully!'
        );
    }

    public function delete(Employer $employer): RedirectResponse
    {
        /**
         * Precaution removal if cascadeOnDelete() does not work
         */
        $employer->job()->delete();
        $employer->user->delete();
        $employer->delete();

        return back()->with(
            'message', 'Employer removed successfully!'
        );
    }

    public function get($id): Employer
    {
        return Employer::with('user')
            ->findOrFail($id);
    }
}
