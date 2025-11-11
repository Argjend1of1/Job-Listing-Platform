<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Response;
use Inertia\ResponseFactory;

//InertiaComplete!!
class AccountController extends Controller
{
    public function index() : ResponseFactory | Response
    {
        return inertia('account/Index', [
            'user' => $this->getUser(),
        ]);
    }

    public function edit() : ResponseFactory | Response
    {
        return inertia('account/Edit', [
            'user' => $this->getUser(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $this->getUser();

        $rules = ['name' => 'required|string|max:255'];
        if ($user->employer) {
            $rules['employer'] = 'required|string|max:100';
        }

        $validated = $request->validate($rules);

        try {
            DB::transaction(function () use ($user, $validated) {
                if ($user->employer) {
                    $user->employer->update([
                        'name' => $validated['employer']
                    ]);
                }

                $user->update(['name' => $validated['name']]);
            });

            return back()->with(
                'message', 'Account updated successfully!'
            );

        } catch (\Exception $e) {
            Log::error('Account update failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return back()->with(
                'error', 'Update failed. Please try again.'
            );
        }
    }

    public function destroy()
    {
        $user = $this->getUser();

        try {
            DB::transaction(function () use ($user) {
                if ($user->employer) {
                    $user->employer->delete();
                }

                $user->delete();
            });
            Auth::logout();

            return back()->with(
                'message', 'Account deleted successfully.'
            );

        }catch (\Exception $e) {
            Log::error('Account deletion failed', [
                'user' => $user,
                'error' => $e->getMessage(),
            ]);

            return back()->with(
                'error', 'Removing your account failed. Please try again!'
            );
        }
    }

    private function getUser(): User
    {
        /** @var User $user */
        return User::with('employer')
                    ->findOrFail(Auth::id());
    }
}
