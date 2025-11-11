<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        return inertia('account/Index');
    }

    public function show()
    {
        $user = Auth::user();
        $employer = $user->employer;

        return response()->json([
            'user' => $user,
            'employer' => $employer
        ]);
    }

    public function edit()
    {
        return inertia('account/Edit', [
            'employer' => Auth::user()->employer
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
        ];

        if ($user->employer) {
            $rules['employer'] = 'required|string|max:100';
        }

        $validated = $request->validate($rules);

        // Update employer name if applicable
        if ($user->employer) {
            $user->employer->update([
                'name' => $validated['employer'],
            ]);

            //no need to update the jobs related to the employer.
            //because we use a foreignId, when we access the job employer,
            //(e.g., $job->employer->name) it will return the updated value.
        }

        // Update user info
        $user->update([
            'name' => $validated['name'],
        ]);

        // Optional: Dispatch email confirmation via queue
        // SendAccountUpdatedEmail::dispatch($user); or use Mail::to($user)->queue(...)

        return redirect('/account')->with(
            'message', 'Account updated successfully!'
        );
    }


    public function destroy()
    {
        $user = Auth::user();

        // Delete related employer if it exists
        if ($user->employer) {
            $user->employer->delete();
        }

        // Delete the user
        $user->delete();

        // Log out user to avoid auth issues after deletion
        Auth::logout();

        return redirect('/')
            ->with('message', 'Account deleted successfully.');
    }
}
