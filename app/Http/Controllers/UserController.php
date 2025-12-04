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
        $user->update([
            'role' => 'admin'
        ]);

        Log::info('User promoted to admin', [
            'target_user_id' => $user->id,
            'performed_by' => auth()->id(),
        ]);

//        dd($user->getChanges());
//        dd($user->getPrevious());

        return back()->with(
            'message', 'User Promoted Successfully!',
        );
    }
}
