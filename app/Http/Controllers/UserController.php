<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request) : Response
    {
        [
            'users' => $users,
            'query' => $query
        ] = UserService::getUsersByRole($request, 'user');

        return inertia('users/Index',[
            'users' => Inertia::scroll(fn () => $users),
            'query' => $query ?? '',
        ]);
    }

    public function update(User $user) : RedirectResponse
    {
        // Precautionary check if the user is already an admin
        if ($user->role === 'admin') {
            return back()->withErrors([
                'error' => 'User is already an admin.'
            ]);
        }

        try {
            $user->role = 'admin';
            $user->save();

            return back()->with(
                'message', 'User Promoted Successfully!',
            );

        }catch (\Exception $e) {
            Log::error('Promotion of user failed', [
                'user' => $user,
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors([
                'error' => 'Something went wrong with promotion. Please try again.'
            ]);
        }
    }
}
