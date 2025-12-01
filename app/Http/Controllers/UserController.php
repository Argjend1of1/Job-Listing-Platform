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
    public function __construct(private UserService $userService){}

    public function index(Request $request) : Response
    {
        [
            'users' => $users,
            'query' => $query
        ] = $this->userService->getUsersByRole($request, 'user');

        return inertia('users/Index',[
            'users' => Inertia::scroll(fn () => $users),
            'query' => $query ?? '',
        ]);
    }

    public function update(User $user) : RedirectResponse
    {

        try {
            $user->role = 'admin';
            $user->save();

//            dd($user->getChanges());
//            dd($user->getPrevious());

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
